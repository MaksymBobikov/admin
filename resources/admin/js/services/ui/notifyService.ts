import { SnackbarColor, snackbarModel } from '@/js/store/common/snackbarModel';

export function notifyInfo(message: string) {
    snackbarModel.text = message;
    snackbarModel.color = SnackbarColor.Info;
    snackbarModel.show = true;
}

export function notifyError(errorMessage: string) {
    snackbarModel.text = errorMessage;
    snackbarModel.color = SnackbarColor.Error;
    snackbarModel.show = true;
}
