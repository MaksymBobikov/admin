import AppHeader from '@/components/AppHeader.vue';
import Login from '@/pages/auth/Login.vue';
import Register from '@/pages/auth/Register.vue';
import ForgotPassword from '@/pages/auth/ForgotPassword.vue';
import ResetPassword from '@/pages/auth/ResetPassword.vue';
import Snackbar from '@/components/Snackbar.vue';
import LoadingOverlay from "@/components/LoadingOverlay.vue";

export const importComponents = (app) => {
    app.component('app-header', AppHeader);
    app.component('login', Login);
    app.component('register', Register);
    app.component('forgot-password', ForgotPassword);
    app.component('reset-password', ResetPassword);
    app.component('snackbar', Snackbar);
    app.component('loading-overlay', LoadingOverlay);
}
