<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { logoutUser} from "@/js/services/api/auth/authService";
import {redirectTo} from "@/js/utilites/helpers";

const { user } = defineProps<{
    user?: Object
}>()

const showMenu = ref(false);

async function logout() {
    const data = await logoutUser();

    if (data?.redirect_url) {
        redirectTo(data.redirect_url);
    }
}

function toggleMenu() {
    showMenu.value = !showMenu.value;
}

</script>

<template>
    <header class="header-bar">
        <div>
            <strong>Admin Dashboard</strong>
        </div>
        <div class="d-flex align-items-center gap-3 position-relative">
            <button class="btn btn-light btn-sm">Notifications 🔔</button>
            <i class="fa-solid fa-user cursor-pointer" @click.prevent="toggleMenu"></i>
            <div v-if="showMenu" class="user-header-menu position-absolute p-3">
                <div>{{ user?.name }}</div>
                <ul class="header-user-menu">
                    <li class="cursor-pointer" v-if="user" @click.prevent="logout">Logout</li>
                </ul>
            </div>
        </div>
    </header>
</template>

<style scoped>

</style>
