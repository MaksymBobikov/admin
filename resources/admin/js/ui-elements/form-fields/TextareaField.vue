<script setup lang="ts">
import {defineProps, defineModel, computed, ref, watch} from 'vue';

const value = defineModel('modelValue', { required: false, default: null });

const {
    name,
    label = '',
    placeholder = '',
    errorMessages = [],
    readonly = false,
    rows = 5,
} = defineProps<{
    name: string,
    label?: string,
    placeholder?: string,
    readonly?: boolean,
    errorMessages?: string[],
    rows?: number,
}>()

</script>

<template>
    <div class="fields-wrap">
        <v-textarea
            v-model="value"
            :name="name"
            :label="label"
            :placeholder="placeholder"
            :readonly="readonly"
            :error-messages="errorMessages"
            :rows="rows"
            variant="outlined"
        ></v-textarea>
    </div>
</template>

<style scoped>

</style>
