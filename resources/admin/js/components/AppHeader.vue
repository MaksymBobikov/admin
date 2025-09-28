<script setup lang="ts">
import { useAuthUser } from '../composable/useAuthUser';
import { logoutUser} from '../services/api/auth/authService';
import { authStore } from '../store/auth/authStore';

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
    <v-app-bar :elevation="1">
        <v-app-bar-title>
            <span class="app-header-title">Header</span>
        </v-app-bar-title>
        <div class="d-flex" v-if="user">
            <div class="mr-5">{{ user.name }}</div>
            <div class="mr-5">
                <img @click.prevent="logout" :src="logoutLogo" class="logout-btn"/>
            </div>
        </div>
    </v-app-bar>
</template>

<style scoped>

</style>
