<script setup lang="ts">
import {defineProps, defineModel} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const value = defineModel('modelValue', { required: false, default: null });

const {name,
    errorMessages = [],
    disabled = false,
    readonly = false,
    multiple = false,
    rules = [],
} = defineProps<{
    name: string,
    disabled?: boolean,
    readonly?: boolean,
    multiple?: boolean,
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);
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
            :rules="preparedRules"
            variant="outlined"
        >
        </v-file-input>
    </div>
</template>

<style scoped>

</style>
