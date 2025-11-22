<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';

const value = defineModel('modelValue', { required: true })

const {name,
    label = '',
    required = false,
    errorMessages = []
} = defineProps<{
    name: string,
    label?: string,
    required?: boolean,
    errorMessages?: string[],
}>()

</script>

<template>
    <div class="fields-wrap">
        <v-number-input
            v-model="value"
            type="text"
            :label="label"
            :error-messages="errorMessages"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
