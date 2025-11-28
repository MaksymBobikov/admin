<script setup lang="ts">
import {defineProps, defineModel} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const values = defineModel('modelValue', { required: false, default: [] });

const {
    errorMessages = [],
    rules = [],
} = defineProps<{
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);

</script>

<template>
    <div class="fields-wrap">
        <div v-for="valueItem in values">
            <v-checkbox
                v-model="valueItem.value"
                :label="valueItem.label"
                :error-messages="errorMessages"
                :rules="preparedRules"
            >
            </v-checkbox>
        </div>
    </div>
</template>

<style scoped>

</style>
