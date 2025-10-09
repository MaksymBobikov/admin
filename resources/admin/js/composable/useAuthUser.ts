import { computed } from 'vue';
import { authStore } from '@/js/store/auth/authStore';

export function useAuthUser() {
    return computed(() => authStore.authUser)
}
