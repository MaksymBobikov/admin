<script setup lang="ts">
import {defineProps, defineModel} from 'vue';

const value = defineModel('modelValue', { required: false, default: null });

const {name,
    errorMessages = [],
    disabled = false,
    readonly = false,
    multiple = false,
} = defineProps<{
    name: string,
    disabled?: boolean,
    readonly?: boolean,
    multiple?: boolean,
    errorMessages?: string[],
}>()
</script>

<template>
    <div class="fields-wrap">
        <v-file-input
            v-model="value"
            :name="name"
            :error-messages="errorMessages"
            :disabled="disabled"
            :readonly="readonly"
            :multiple="multiple"
            variant="outlined"
        >
        </v-file-input>
    </div>
</template>

<style scoped>

</style>
