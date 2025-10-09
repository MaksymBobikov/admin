import { computed } from 'vue';
import { isLoadingStore } from '@/js/store/common/isLoadingStore';

export function useIsLoading() {
    return computed(() => isLoadingStore.loading);
}
