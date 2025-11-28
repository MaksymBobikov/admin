<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const value = defineModel('modelValue', { required: true })

const {name,
    label = '',
    required = false,
    errorMessages = [],
    rules = [],
} = defineProps<{
    name: string,
    label?: string,
    required?: boolean,
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);

</script>

<template>
    <div class="fields-wrap">
        <v-number-input
            v-model="value"
            type="text"
            :label="label"
            :error-messages="errorMessages"
            :rules="preparedRules"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
