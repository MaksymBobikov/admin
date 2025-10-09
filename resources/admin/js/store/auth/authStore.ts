import { reactive } from 'vue';
import { AuthUserInterface } from '@/js/domain/interfaces/auth/AuthUserInterface';

export const authStore = reactive({
    isAuthenticatedUser: false,
    authUser: null as AuthUserInterface | null,
    setIsAuthenticatedUser(value: boolean) {
        this.isAuthenticatedUser = value;
    },
    getIsAuthenticatedUser(): boolean {
        return this.isAuthenticatedUser;
    },
    setAuthUser(user: AuthUserInterface | null) {
        this.authUser = user;
        this.isAuthenticatedUser = !!user;
        this.saveToLocalStorage();
    },
    saveToLocalStorage() {
        localStorage.setItem('isAuthUser', this.isAuthenticatedUser ? 1 : 0);
    }
});
