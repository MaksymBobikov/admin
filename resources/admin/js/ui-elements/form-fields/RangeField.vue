<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';
import {useValidationRules} from "@/js/composable/useValidationRules";

const range = defineModel('modelValue', { required: true })

const {name,
    minValue,
    maxValue,
    step = 1,
    label = '',
    required = false,
    errorMessages = [],
    rules = [],
} = defineProps<{
    name: string,
    minValue: number,
    maxValue: number,
    step?: number,
    label?: string,
    required?: boolean,
    errorMessages?: string[],
    rules?: any[],
}>()

const preparedRules = useValidationRules(rules);

</script>

<template>
    <div class="fields-wrap">
        <v-range-slider
            :label="label"
            v-model="range"
            :max="maxValue"
            :min="minValue"
            :step="step"
            :rules="preparedRules"
            class="align-center"
            hide-details
        >
            <template v-slot:prepend>
                <v-text-field
                    v-model="range[0]"
                    density="compact"
                    style="width: 70px"
                    type="number"
                    variant="outlined"
                    hide-details
                    single-line
                ></v-text-field>
            </template>
            <template v-slot:append>
                <v-text-field
                    v-model="range[1]"
                    density="compact"
                    style="width: 70px"
                    type="number"
                    variant="outlined"
                    hide-details
                    single-line
                ></v-text-field>
            </template>
        </v-range-slider>
    </div>
</template>

<style scoped>

</style>
