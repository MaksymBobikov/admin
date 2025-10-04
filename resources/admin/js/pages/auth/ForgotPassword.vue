<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { useRules } from 'vuetify/labs/rules';
import { forgotPassword } from '@/services/api/auth/authService';
import { ForgotPasswordInterface } from '@/domain/interfaces/auth/ForgotPasswordInterface';
import { serverValidationStore } from '@/store/common/serverValidationStore';
import { redirectTo } from "@/utilites/helpers";

const forgotPasswordForm = ref();

serverValidationStore.initErrorMessages(['email']);

const fieldServerEmailErrors = computed(() => serverValidationStore.errorMessages.email);
const rules = useRules();

const requestData = reactive<ForgotPasswordInterface>({
    email: '',
});

async function sendForgotPassword() {
    const { valid } =  await forgotPasswordForm.value.validate();

    if (valid) {
        const { data } = await forgotPassword(requestData);

        if (data.success) {
            redirectTo('/admin/login');
        }
    }
}
</script>

<template>
    <v-container class="auth-container">
        <v-card class="app-auth-block">
            <h4 class="login-page-title">Send request to restore your password</h4>
            <p class="mb-10">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
            <v-form ref="forgotPasswordForm" @submit.prevent="sendForgotPassword">
                <div class="fields-wrap">
                    <v-text-field
                        v-model="requestData.email"
                        type="email"
                        label="Email"
                        :rules="[rules.required(), rules.email()]"
                        :error-messages="fieldServerEmailErrors"
                        @input="serverValidationStore.clearByName('email')"
                        variant="outlined"
                    />
                </div>
                <div class="d-flex justify-end mb-4">
                    <button class="app-btn">Send</button>
                </div>
            </v-form>
        </v-card>
    </v-container>
</template>

<style scoped>

</style>
