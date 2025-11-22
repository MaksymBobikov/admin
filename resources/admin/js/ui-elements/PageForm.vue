<script setup lang="ts">
import {defineProps, reactive, ref, computed} from 'vue';
import {DataObjectInterface} from "@/js/domain/interfaces/ui/filter/DataObjectInterface";
import {apiClient} from "@/js/utilites/apiClient";
import {serverValidationStore} from "@/js/store/common/serverValidationStore";

const {data = {}, actionUrl, defaultSaveButton = true} = defineProps<{
    actionUrl: string,
    defaultSaveButton?: boolean,
    data?: DataObjectInterface,
}>()

const serverErrors = computed(() => serverValidationStore.errorMessages);
const fieldNames = computed(() => Object.keys(data));

const pageForm = ref();

async function onSubmit() {
    serverValidationStore.initErrorMessages(fieldNames.value);

    const { valid } =  await pageForm.value.validate();

    if (valid) {
        const { resultData } = await apiClient.post(actionUrl, data);

        if (resultData?.success) {

        }
    }
}
</script>

<template>
    <div>
        <v-form ref="pageForm" @submit.prevent="onSubmit">
            <slot :on-submit="onSubmit" :server-errors="serverErrors"></slot>
            <div v-if="$slots.submit">
                <slot name="submit" :on-submit="onSubmit"></slot>
            </div>
            <div v-else>
                <div v-if="defaultSaveButton">
                    <v-btn @click="onSubmit">Save</v-btn>
                </div>
            </div>
        </v-form>
    </div>
</template>

<style scoped>

</style>
