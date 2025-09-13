<script setup lang="ts">
//import { useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
//import { verifyEmail } from '../../services/api/auth/authService';

const verificationResult = ref('');

//const router = useRouter();
//const { id, hash } = router.currentRoute.value.params;

/*onMounted(async () => {
    const { data } = await verifyEmail(+id, hash, router.currentRoute.value.query);

    verificationResult.value = !!data.success ? 'Email has been verificated!' : 'Verification error!';
});*/

</script>

<template>
    <v-container class="auth-container">
        <v-card class="app-auth-block">
            <h2 class="text-center verification-result-text">Verification of your email</h2>
            <p class="mb-10 mt-10 verification-result-text">{{ verificationResult }}</p>
            <div class="mt-10">
            </div>
        </v-card>
    </v-container>
</template>

<style scoped>
.verification-result-text {
    font-weight: bold;
}
</style>
