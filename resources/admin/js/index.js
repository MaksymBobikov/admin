import AppHeader from '@/js/components/AppHeader.vue';
import Login from '@/js/pages/auth/Login.vue';
import Register from '@/js/pages/auth/Register.vue';
import ForgotPassword from '@/js/pages/auth/ForgotPassword.vue';
import ResetPassword from '@/js/pages/auth/ResetPassword.vue';
import Snackbar from '@/js/components/Snackbar.vue';
import LoadingOverlay from "@/js/components/LoadingOverlay.vue";
import Sidebar from '@/js/components/Sidebar.vue';

export const importComponents = (app) => {
    app.component('app-header', AppHeader);
    app.component('login', Login);
    app.component('register', Register);
    app.component('forgot-password', ForgotPassword);
    app.component('reset-password', ResetPassword);
    app.component('snackbar', Snackbar);
    app.component('loading-overlay', LoadingOverlay);
    app.component('sidebar', Sidebar);
}
