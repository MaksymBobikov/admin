import { reactive } from 'vue';

export enum SnackbarColor {
    Error = 'red',
    Info = '#b6b4b4'
}
export const snackbarModel = reactive({
    show: false,
    text: '',
    color: SnackbarColor.Info
});
