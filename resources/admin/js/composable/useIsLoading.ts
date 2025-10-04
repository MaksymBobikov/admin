import { computed } from 'vue';
import { isLoadingStore } from '@/store/common/isLoadingStore';

export function useIsLoading() {
    return computed(() => isLoadingStore.loading);
}
