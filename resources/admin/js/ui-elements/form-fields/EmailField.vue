<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const email = defineModel('modelValue', { required: true, type: String });

const {name,
    label = 'Email',
    required = false,
    errorMessages = [],
    rules = []
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
        <v-text-field
            v-model="email"
            type="email"
            :label="label"
            :rules="preparedRules"
            :error-messages="errorMessages"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
