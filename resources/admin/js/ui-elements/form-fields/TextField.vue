<script setup lang="ts">
import { defineProps, defineModel } from 'vue';
import { serverValidationStore } from "@/js/store/common/serverValidationStore";
import { useValidationRules } from "@/js/composable/useValidationRules";

const value = defineModel('modelValue', { required: true })

const {name,
    label = '',
    errorMessages = [],
    rules = [],
} = defineProps<{
    name: string,
    label?: string,
    errorMessages?: string[],
    rules?: any[],
}>()

serverValidationStore.initErrorMessage(name);

const preparedRules = useValidationRules(rules);

</script>

<template>
    <div class="fields-wrap">
        <v-text-field
            v-model="value"
            type="text"
            :label="label"
            :rules="preparedRules"
            :error-messages="errorMessages"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
