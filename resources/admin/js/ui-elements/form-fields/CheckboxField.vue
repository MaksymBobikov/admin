<script setup lang="ts">
import {defineProps, defineModel} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const value = defineModel('modelValue', { required: false, default: null });

const {name,
    label = '',
    required = false,
    readonly = false,
    disabled = false,
    clearable = false,
    errorMessages = [],
    rules = []
} = defineProps<{
    name: string,
    label?: string,
    required?: boolean,
    clearable?: boolean,
    disabled?: boolean,
    readonly?: boolean,
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);

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
            :rules="preparedRules"
        >
        </v-checkbox>
    </div>
</template>

<style scoped>

</style>
