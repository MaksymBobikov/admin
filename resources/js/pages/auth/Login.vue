<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { useRules } from 'vuetify/labs/rules';
import { LoginDataInterface } from '../../domain/interfaces/auth/LoginDataInterface';
import { loginUser } from '../../services/api/auth/authService';
import { serverValidationStore } from '../../store/common/serverValidationStore';
import {redirectTo} from '../../utilites/helpers';

const loginForm = ref();

serverValidationStore.initErrorMessages(['email', 'password']);

const fieldServerEmailErrors = computed(() => serverValidationStore.errorMessages.email);
const fieldServerPasswordErrors = computed(() => serverValidationStore.errorMessages.password);

const rules = useRules();

const loginData = reactive<LoginDataInterface>({
    email: '',
    password: ''
});

async function login() {
    const { valid } =  await loginForm.value.validate();

    if (valid) {
        const { data } = await loginUser(loginData);

        if (data?.success) {
            redirectTo( data?.redirect_url || '/admin');
        }
    }
}
</script>

<template>
    <v-container class="auth-container">
        <v-card class="app-auth-block">
            <h2 class="login-page-title">Login</h2>
            <p class="mb-10">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
            <v-form ref="loginForm" @submit.prevent="login">
                <div class="fields-wrap">
                    <v-text-field
                        v-model="loginData.email"
                        type="email"
                        label="Email"
                        :rules="[rules.required(), rules.email()]"
                        :error-messages="fieldServerEmailErrors"
                        @input="serverValidationStore.clearByName('email')"
                        variant="outlined"
                    />
                </div>
                <div class="fields-wrap">
                    <v-text-field
                        v-model="loginData.password"
                        type="password"
                        label="Password"
                        :rules="[rules.required()]"
                        :error-messages="fieldServerPasswordErrors"
                        @input="serverValidationStore.clearByName('password')"
                        variant="outlined"
                    />
                </div>
                <div class="d-flex justify-end mb-4">
                    <button class="app-btn">Login</button>
                </div>
            </v-form>
        </v-card>
    </v-container>
</template>

<style scoped>

</style>
