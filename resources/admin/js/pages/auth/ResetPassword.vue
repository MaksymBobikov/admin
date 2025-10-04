<script setup lang="ts">
import { computed, reactive, ref } from 'vue';
import { useRules } from 'vuetify/labs/rules';
import { updatePassword } from '@/services/api/auth/authService';
import { ResetPasswordDataInterface } from '@/domain/interfaces/auth/ResetPasswordDataInterface';
import { serverValidationStore } from '@/store/common/serverValidationStore';
import { redirectTo } from '@/utilites/helpers';

const resetPasswordForm = ref();

serverValidationStore.initErrorMessages(['password', 'password_confirmation']);

const fieldServerPasswordErrors = computed(() => serverValidationStore.errorMessages.password);
const fieldServerPasswordConfirmationErrors = computed(() => serverValidationStore.errorMessages.password_confirmation);

const rules = useRules();

const token = 'test@test.com';
const email = 'test';

const resetPasswordData = reactive<ResetPasswordDataInterface>({
    token,
    email,
    password: '',
    password_confirmation: '',
});

async function resetPassword() {
    const { valid } =  await resetPasswordForm.value.validate();

    if (valid) {
        const { data } = await updatePassword(resetPasswordData);

        if (data.success) {
            redirectTo('/admin/login');
        }
    }
}

const confirmPasswordRule = (v) => v === resetPasswordData.password || 'Value must be equal to Password value';

</script>

<template>
    <v-container class="auth-container">
        <v-card class="app-auth-block">
            <h4 class="login-page-title">Reset password</h4>
            <p class="mb-10">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
            <v-form ref="resetPasswordForm" @submit.prevent="resetPassword">
                <div class="fields-wrap">
                    <v-text-field
                        v-model="resetPasswordData.password"
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
                        v-model="resetPasswordData.password_confirmation"
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
                        class="app-btn">Reset password</button>
                </div>
                <div>
                </div>
            </v-form>
        </v-card>
    </v-container>
</template>

<style scoped>

</style>
