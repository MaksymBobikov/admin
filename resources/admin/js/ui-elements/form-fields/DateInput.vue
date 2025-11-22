<script setup lang="ts">
import {defineProps, defineModel, computed, ref, watch} from 'vue';
import {dateService} from "@/js/utilites/dateService";
import {useClickOutside} from "@/js/composable/useClickOutside";
import {serverValidationStore} from "@/js/store/common/serverValidationStore";

const rangeValue = 'range';

const value = defineModel('modelValue', { required: false, default: null });
const dateInputBoxRef = ref<HTMLInputElement>(null);

const {
    name,
    label = '',
    placeholder = '',
    inputFormat = 'yyyy-mm-dd',
    displayFormat = 'yyyy-mm-dd',
    firstDayOfWeek = 1,
    disabled = false,
    clearable = false,
    multiple = false,
    readonly = false,
    allowedDates = [],
    errorMessages = [],
} = defineProps<{
    name: string,
    label?: string,
    inputFormat?: string,
    displayFormat?: string,
    placeholder?: string,
    disabled?: boolean,
    clearable?: boolean,
    readonly?: boolean,
    multiple?: any,
    allowedDates?: any[],
    errorMessages?: string[],
    firstDayOfWeek?: number,
}>()

const showMenu = ref(false);

const isRange = computed(() => multiple === rangeValue);

const dateRangeText = computed(() => isRange.value ? value.value/*.map(itm => itm ? dateService.toFormat(itm, 'yyyy-LL-dd', dateService.getDateFormat()) : itm)*/.join(' ~ ') : value.value); //dateService.toFormat(value.value, 'yyyy-LL-dd', dateService.getDateFormat()));
const dateRange = computed(() => isRange.value ? value.value.sort((a: any, b: any) => dateService.isAfter(a, b) ? 1 : -1) : []);

function closeMenu() {
    showMenu.value = false;
}

function openMenu() {
    showMenu.value = true;
}

watch(dateRange, (newValue, oldValue) => {
    if (isRange.value) {
        value.value = newValue;
    }
});

serverValidationStore.initErrorMessage(name);

useClickOutside(dateInputBoxRef, closeMenu, ['select-box__variant-item','search-box__checkbox']);
</script>

<template>
    <div class="fields-wrap">
        <v-date-input
            :name="name"
            v-model="value"
            :label="label"
            variant="outlined"
            :clearable="clearable"
            :input-format="inputFormat"
            :display-format="displayFormat"
            :disabled="disabled"
            :error-messages="errorMessages"
            :first-day-of-week="firstDayOfWeek"
            :placeholder="placeholder"
            :readonly="readonly"
        ></v-date-input>
    </div>
</template>

<style scoped>

</style>
