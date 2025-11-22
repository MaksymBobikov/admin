<script setup lang="ts">
import { defineProps } from 'vue';
import {RadioButtonInterface} from "@/js/domain/interfaces/ui/radiobutton/RadioButtonInterface";

const value = defineModel('modelValue', { required: true })

const {name,
    label = '',
    values = [],
    required = false,
    errorMessages = []
} = defineProps<{
    name: string,
    values?: RadioButtonInterface[],
    label?: string,
    required?: boolean,
    errorMessages?: string[],
}>()

</script>

<template>
    <div class="fields-wrap">
        <v-radio-group :error-messages="errorMessages" :label="label" v-model="value">
            <v-radio v-for="item in values" :label="item.title" :value="item.value"></v-radio>
        </v-radio-group>
    </div>
</template>

<style scoped>

</style>
