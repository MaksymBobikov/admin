<script setup lang="ts">
import { ref, defineProps, reactive} from 'vue';
import { useRules } from 'vuetify/labs/rules';
import {DataObjectInterface} from "@/js/domain/interfaces/ui/filter/DataObjectInterface";

const {data = {}} = defineProps<{
    data?: DataObjectInterface
}>()

const emit = defineEmits(['search']);

const filterData = reactive({
    ...data,
    search: ''
});

const pageFilterForm = ref();
const rules = useRules();

async function search() {
    emit('search', filterData);
}

</script>

<template>
    <div>
        <v-form ref="pageFilterForm" @submit.prevent="search">
            <div v-if="$slots.default">
                <slot :filterData="filterData"></slot>
            </div>
            <div v-else>
                <v-text-field
                    name="search"
                    v-model="filterData.search"
                    type="text"
                    label="Search"
                    :rules="[rules.required()]"
                    variant="outlined"
                />
                <button class="app-btn">Search</button>
            </div>
        </v-form>
    </div>

</template>

<style scoped>

</style>
