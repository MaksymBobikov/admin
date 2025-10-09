<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { useRules } from 'vuetify/labs/rules';
import { RegisterDataInterface } from '@/js/domain/interfaces/auth/RegisterDataInterface.js';
import { registerUser } from '@/js/services/api/auth/authService';
import { serverValidationStore } from '@/js/store/common/serverValidationStore';
import { redirectTo } from '@/js/utilites/helpers';

const registerForm = ref();

serverValidationStore.initErrorMessages(['name','email', 'password', 'password_confirmation']);

const fieldServerNameErrors = computed(() => serverValidationStore.errorMessages.name);
const fieldServerEmailErrors = computed(() => serverValidationStore.errorMessages.email);
const fieldServerPasswordErrors = computed(() => serverValidationStore.errorMessages.password);
const fieldServerPasswordConfirmationErrors = computed(() => serverValidationStore.errorMessages.password_confirmation);

const registerData = reactive<RegisterDataInterface>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const rules = useRules();

async function register() {
    const { valid } =  await registerForm.value.validate();

    if (valid) {
        const { data } = await registerUser(registerData);

        if (data?.success) {
            redirectTo( data?.redirect_url || '/admin');
        }
    }
}

const confirmPasswordRule = (v) => v === registerData.password || 'Value must be equal to Password value';

</script>

<template>
    <v-container class="auth-container">
        <v-card class="app-auth-block">
            <h4 class="login-page-title">Create your account</h4>
            <p class="mb-10">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
            <v-form ref="registerForm" @submit.prevent="register">
                <div class="fields-wrap">
                    <v-text-field
                        v-model="registerData.name"
                        type="text"
                        label="Name"
                        :rules="[rules.required()]"
                        :error-messages="fieldServerNameErrors"
                        @input="serverValidationStore.clearByName('name')"
                        variant="outlined"
                    />
                </div>
                <div class="fields-wrap">
                    <v-text-field
                        v-model="registerData.email"
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
                        v-model="registerData.password"
                        type="password"
                        label="Password"
                        :rules="[rules.required(), rules.minLength(8)]"
                        :error-messages="fieldServerPasswordErrors"
                        @input="serverValidationStore.clearByName('password')"
                        variant="outlined"
                    />
                </div>
                <div class="fields-wrap">
                    <v-text-field
                        v-model="registerData.password_confirmation"
                        type="password"
                        label="Repeat Password"
                        :rules="[rules.required(), rules.minLength(8), confirmPasswordRule]"
                        :error-messages="fieldServerPasswordConfirmationErrors"
                        @input="serverValidationStore.clearByName('password_confirmation')"
                        variant="outlined"
                    />
                </div>
                <div class="d-flex justify-end mb-4">
                    <button
                        class="app-btn">Create Account</button>
                </div>
            </v-form>
        </v-card>
    </v-container>
</template>

<style scoped>

</style>
