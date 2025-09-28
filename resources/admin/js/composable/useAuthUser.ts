import { computed } from 'vue';
import { authStore } from '../store/auth/authStore';

export function useAuthUser() {
    return computed(() => authStore.authUser)
}
