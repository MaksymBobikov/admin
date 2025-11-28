<script setup lang="ts">
import { defineProps } from 'vue';
import {RadioButtonInterface} from "@/js/domain/interfaces/ui/radiobutton/RadioButtonInterface";
import {useValidationRules} from "@/js/composable/useValidationRules";

const value = defineModel('modelValue', { required: true })

const {name,
    label = '',
    values = [],
    required = false,
    errorMessages = [],
    rules = [],
} = defineProps<{
    name: string,
    values?: RadioButtonInterface[],
    label?: string,
    required?: boolean,
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);

</script>

<template>
    <div class="fields-wrap">
        <v-radio-group :rules="preparedRules" :error-messages="errorMessages" :label="label" v-model="value">
            <v-radio v-for="item in values" :label="item.title" :value="item.value"></v-radio>
        </v-radio-group>
    </div>
</template>

<style scoped>

</style>
