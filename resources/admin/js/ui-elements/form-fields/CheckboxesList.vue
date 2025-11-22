<script setup lang="ts">
import {defineProps, defineModel} from 'vue';

const values = defineModel('modelValue', { required: false, default: [] });

const {
    errorMessages = []
} = defineProps<{
    errorMessages?: string[],
}>()

</script>

<template>
    <div class="fields-wrap">
        <div v-for="valueItem in values">
            <v-checkbox
                v-model="valueItem.value"
                :label="valueItem.label"
                :error-messages="errorMessages"
            >
            </v-checkbox>
        </div>
    </div>
</template>

<style scoped>

</style>
