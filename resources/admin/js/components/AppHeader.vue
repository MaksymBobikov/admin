<script setup lang="ts">
import { useAuthUser } from '@/js/composable/useAuthUser';
import { logoutUser} from '@/js/services/api/auth/authService';
import { authStore } from '@/js/store/auth/authStore';

const logoutLogo = '/assets/logout.png';

const user = useAuthUser();

async function logout() {
    const response = await logoutUser();

    if (response) {
        authStore.setAuthUser(null);
    }
}

</script>

<template>
    <header class="header-bar">
        <div>
            <strong>Admin Dashboard</strong>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light btn-sm">Notifications 🔔</button>
            <button class="btn btn-outline-light btn-sm">Login</button>
        </div>
    </header>
</template>

<style scoped>

</style>
