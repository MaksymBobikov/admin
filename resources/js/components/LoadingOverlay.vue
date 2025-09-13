<script setup>
import { useIsLoading } from '../composable/useIsLoading.js';

const overlay = useIsLoading();

</script>

<template>
    <v-overlay :model-value="overlay" class="align-center justify-center" :persistent="true">
        <v-progress-circular
            size="64"
            indeterminate
        ></v-progress-circular>
    </v-overlay>
</template>

<style scoped>

</style>
