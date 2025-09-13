<script setup lang="ts">
import { ref } from 'vue';
import { sendVerificationRequest } from '../services/api/user/userService';

const sendResult = ref(null);

async function sendRequest() {
    sendResult.value = await sendVerificationRequest();
}

</script>

<template>
    <v-card class="app-auth-block">
        <h4 class="login-page-title">Please verify your email</h4>
        <p class="mb-10" v-if="sendResult === null">Please check your email or send verification request to your email address</p>
        <p class="mb-10" v-if="sendResult === true">Verification request has been send, please check your email</p>
        <p class="mb-10" v-if="sendResult === false">Error, please try again later</p>
        <div class="mt-10" v-if="sendResult !== true">
            <button
                class="app-btn"
                @click.prevent="sendRequest">Send verification email</button>
        </div>
    </v-card>
</template>

<style scoped>

</style>
