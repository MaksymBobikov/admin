<script setup lang="ts">
import {defineProps, defineModel} from 'vue';

const value = defineModel('modelValue', { required: false, default: null });

const {name,
    label = '',
    required = false,
    readonly = false,
    disabled = false,
    clearable = false,
    errorMessages = []
} = defineProps<{
    name: string,
    label?: string,
    required?: boolean,
    clearable?: boolean,
    disabled?: boolean,
    readonly?: boolean,
    errorMessages?: string[],
}>()

</script>

<template>
    <div class="fields-wrap">
        <v-checkbox
            v-model="value"
            :name="name"
            :label="label"
            :readonly="readonly"
            :disabled="disabled"
            :clearable="clearable"
            :error-messages="errorMessages"
        >
        </v-checkbox>
    </div>
</template>

<style scoped>

</style>
