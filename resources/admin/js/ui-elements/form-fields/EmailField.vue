<script setup lang="ts">
import {defineProps, defineModel, computed} from 'vue';
import {useRules} from 'vuetify/labs/rules';
import {serverValidationStore} from "@/js/store/common/serverValidationStore";

const email = defineModel('modelValue', { required: true, type: String });

const {name,
    label = 'Email',
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
    const emailRules = [rules.email()];

    if (required) {
        emailRules.push(rules.required());
    }

    return emailRules;
});

</script>

<template>
    <div class="fields-wrap">
        <v-text-field
            v-model="email"
            type="email"
            :label="label"
            :rules="computedRules"
            :error-messages="errorMessages"
            variant="outlined"
        />
    </div>
</template>

<style scoped>

</style>
