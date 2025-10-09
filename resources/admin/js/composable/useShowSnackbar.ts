import { computed } from 'vue';
import { snackbarModel } from '@/js/store/common/snackbarModel';

export function useShowSnackbar() {
    return computed(() => snackbarModel.show);
}
export function useTextSnackbar() {
    return computed(() => snackbarModel.text);
}

export function useColorSnackbar() {
    return computed(() => snackbarModel.color);
}
