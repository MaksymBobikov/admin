<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';
import {useRules} from 'vuetify/labs/rules';
import {serverValidationStore} from "@/js/store/common/serverValidationStore";

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

serverValidationStore.initErrorMessage(name);

const rules = useRules();

const computedRules = computed(() => {
    const textRules = [];

    if (required) {
        textRules.push(rules.required());
    }

    return textRules;
});

</script>

<template>
    <div class="fields-wrap">
        <v-text-field
            v-model="value"
            type="text"
            :label="label"
            :rules="computedRules"
            :error-messages="errorMessages"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
