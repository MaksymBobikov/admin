<?php

namespace App\Models\Traits;


use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

trait CloneTrait
{
    /**
     * Clone the current model instance along with its specified relationships and media.
     *
     * This method creates a clone of the model, replicating certain fields and setting new values
     * for the created and updated by admin user IDs.
     *
     * @param array $relations An array of relationships to clone and sync with the new instance.
     * @param array $medias An array of media collections to clone and associate with the new instance.
     * @param array $nonReplicateFields An array of non replicate fields.
     * @param array $fillFields An array of fill fields.
     * @return \Illuminate\Database\Eloquent\Model|mixed The cloned model instance.
     */
    public function clone(array $relations = [], array $medias = [], array $nonReplicateFields = [], array $fillFields = []): mixed
    {
        return DB::transaction(function() use ($relations, $medias, $nonReplicateFields, $fillFields){
            try{
                $clone = $this->replicate(array_merge([
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'restored_at',
                    'default',
                    'system',
                    'external_id',
                    'deleted_by_admin_user_id',
                    'restored_by_admin_user_id',
                ], $nonReplicateFields))->fill(array_merge([
                    'created_by_admin_user_id' => Auth::getUser()->id,
                    'updated_by_admin_user_id' => Auth::getUser()->id,
                ], $fillFields));

                $clone->save();
            } catch(Exception $e){
                Log::error('Failed to replicate or save model: ' . $e->getMessage());

                throw $e;
            }

            try{
                $this->load($relations);

                foreach($this->getRelations() as $relation => $items){
                    if(in_array($relation, $relations)){
                        if(method_exists($this->{$relation}(), 'getPivotColumns')){
                            $foreignPivotKey = $this->{$relation}()->getForeignPivotKeyName();
                            $relatedPivotKey = $this->{$relation}()->getRelatedPivotKeyName();

                            $syncData = [];

                            foreach($items as $item){
                                $pivotData = $item->pivot
                                    ? $item->pivot->toArray()
                                    : [];

                                unset($pivotData[$foreignPivotKey], $pivotData[$relatedPivotKey]);

                                $syncData[$item->id] = $pivotData;
                            }

                            $clone->{$relation}()->sync($syncData);
                        } else{
                            $clone->{$relation}()->sync($items->pluck('id')->toArray());
                        }
                    }
                }
            } catch(Exception $e){
                Log::error('Failed to sync relations for model clone: ' . $e->getMessage());

                throw $e;
            }

            $newMedias = [];

            try{
                foreach($medias as $media){
                    foreach($this->getMedia($media) as $item){
                        $newMedia = $item->copy($clone, $media);

                        $newMedias[] = $newMedia;
                    }
                }
            } catch(Exception $e){
                Log::error('Failed to clone media collections: ' . $e->getMessage());

                $this->cleanupNewMedias($newMedias);

                throw $e;
            }

            if($this->seo){
                try{
                    $clonedSeo = $this->seo->clone(
                        ['metaAttributes'],
                        $this->seo->getMediaCollections()->keys()->toArray(),
                        [
                            'seoable_type',
                            'seoable_id'
                        ],
                        [
                            'seoable_type' => get_class($clone),
                            'seoable_id' => $clone->id,
                        ]
                    );
                } catch(Exception $e){
                    Log::error('Failed to clone SEO data: ' . $e->getMessage());

                    $this->cleanupNewMedias($newSeoMedias);

                    throw $e;
                }
            }

            return $clone;
        });
    }

    /**
     * Clean up any media files created during the process.
     *
     * @param array $newMedias
     * @return void
     */
    protected function cleanupNewMedias(array $newMedias): void
    {
        foreach($newMedias as $newMedia){
            try{
                if($newMedia){
                    $newMedia->delete();
                }
            } catch(Exception $e){
                Log::error('Failed to delete media file: ' . $e->getMessage());
            }
        }
    }
}
