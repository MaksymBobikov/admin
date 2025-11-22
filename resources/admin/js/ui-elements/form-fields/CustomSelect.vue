<script setup lang="ts">
import {defineProps, defineModel, computed, ref, watch} from 'vue';
import { useClickOutside } from '@/js/composable/useClickOutside';

const searchableSearchInputRef = ref(null);
const searchBoxSearchInputRef = ref(null);
const listsBoxRef = ref<HTMLInputElement>(null);

const emit = defineEmits(['search', 'selected-value']);
const value = defineModel('modelValue', { required: false, default: null });

const {name,
    label = '',
    placeholder = '',
    displayPropertyName = '',
    idProperty = '',
    options = [],
    required = false,
    isMulti = false,
    isSearchable = false,
    isSearchBox = false,
    isDisabled = false,
    errorMessages = [],
} = defineProps<{
    name: string,
    placeholder?: string,
    displayPropertyName?: string,
    idProperty?: string,
    options?: any[],
    label?: string,
    required?: boolean,
    isMulti?: boolean,
    isSearchable?: boolean,
    isSearchBox?: boolean,
    isDisabled?: boolean,
    errorMessages?: string[],
}>()

const searchText = ref('');
const showOptions = ref(false);
const madeSearch = ref(false);
const fieldId = ref(`${Math.random()}`);

const visibleValue = computed(() => !isMulti && value.value ? getDisplayValue(value.value) : '');

const selectedMultiOptions = computed(() => {
    return isMulti ? options.map(item => {
        return {
            ...item,
            isChecked: Boolean(value.value.find((itm: any) => getTrackByData(itm) === getTrackByData(item))),
        }
    }) : [];
});

const filteredOptions = computed(() => {
    if (isSearchable && searchText.value) {
        return options.filter((itm) => getDisplayValue(itm).toLowerCase().startsWith(searchText.value.toLowerCase()));
    }

    return options;
});

const searchableSearchInput = computed(() => {
    return 'searchable_input_' + fieldId
})

const searchBoxSearchInput = computed(() => {
    return 'search_box_input_' + fieldId
});

function getDisplayValue(item: any): String {
    if (displayPropertyName) {
        if (item.hasOwnProperty(displayPropertyName)) {
            return item[displayPropertyName];
        } else {
            console.error('CustomSearch field ' + displayPropertyName + ' does not exist');
        }
    }

    return item;
}

function onInput() {
    showOptions.value = true;
    emit('search', searchText);
}

const closeMenu = () => {
    showOptions.value = false;
}

function toggleMenu() {
    if (!isDisabled) {
        showOptions.value = !showOptions.value;

        if (isSearchable && showOptions.value) {
            searchableSearchInputRef.value.focus();
        }

        if (isMulti && showOptions.value) {
            searchBoxSearchInputRef.value.focus();
        }
    }
}

function toggleOnSearch() {
    if (!isMulti) {
        toggleMenu();
    }
}

function selectValue(item: any) {
    if (isMulti) {
        const i = value.value.findIndex((itm: any) => getTrackByData(itm) === getTrackByData(item));

        if (i !== -1) {
            value.value.splice(i, 1);
        } else {
            value.value.push(item);
        }

        value.value = idProperty ? value.value.map(itm => getTrackByData(itm)) : value.value;

        emit('selected-value', value.value);
    } else {
        value.value = idProperty ? item[idProperty] : item;

        if (isSearchBox) {
            searchText.value = visibleValue.value;
        }

        emit('selected-value', value.value);

        closeMenu();
    }

    madeSearch.value = false;
}

function removeSelectedValue(i) {
    if (isMulti) {
        value.value.splice(i, 1);
        emit('selected-value', idProperty ? value.value.map( (itm: any) => getTrackByData(itm)) : value.value);
    }
}

function getTrackByData(item: any) {
    if (item && idProperty) {
        if (item.hasOwnProperty(idProperty)) {
            return item[idProperty];
        } else {
            console.error('CustomSearch getTrackByData field ' + idProperty + ' does not exist');
        }
    }

    return item;
}

watch(() => options, (newOptions) => {
    madeSearch.value = true;
});

useClickOutside(listsBoxRef, closeMenu, ['select-box__variant-item','search-box__checkbox']);
</script>

<template>
    <div class="fields-wrap">
        <div>
            <label>{{ label }}</label>
        </div>
        <div ref="listsBoxRef" :class="{'_selected': !isMulti && value, 'select-box': !isSearchBox && !isMulti, 'search-box': isSearchBox || isMulti, '_active': showOptions}">
            <div v-if="isMulti && value.length > 0" class="search-box__selected-values selected-values">
                <button :key="i" v-for="(selectedItem, i) in value" @click.prevent="removeSelectedValue(i)" class="selected-values__item">{{ getDisplayValue(selectedItem) }}</button>
            </div>

            <button v-if="!isSearchBox" @click.prevent="toggleMenu" class="select-box__value">{{ visibleValue || placeholder }}</button>

            <div v-if="isSearchBox || (isMulti && showOptions)" class="search-box__search-field">
                <input :id="searchBoxSearchInput" ref="searchBoxSearchInputRef" :disabled="isDisabled" v-model="searchText" @click.prevent="toggleOnSearch" @input="onInput" type="text" class="search-box__input form-field__item input" :placeholder="placeholder">
            </div>

            <div v-if="showOptions && !isMulti && (isSearchable && filteredOptions.length > 0 || !isSearchable && options.length > 0)" :class="{'search-box__dropdown': isSearchBox, 'select-box__dropdown': !isSearchBox}">
                <div v-if="isSearchable" class="select-box__search">
                    <input :id="searchableSearchInput" :disabled="isDisabled" ref="searchableSearchInputRef" v-model="searchText" type="text" :placeholder="placeholder" class="form-field__item">
                </div>
                <ul v-if="isSearchable && filteredOptions.length > 0" :class="{'search-box__variants': isSearchBox, 'select-box__variants': !isSearchBox}">
                    <li :key="i" v-for="(item, i) in filteredOptions" @click.prevent="selectValue(item)" class="select-box__variant-item">{{ getDisplayValue(item) }}</li>
                </ul>
                <ul v-if="!isSearchable && options.length > 0" :class="{'search-box__variants': isSearchBox, 'select-box__variants': !isSearchBox}">
                    <li :key="i" v-for="(item, i) in options" @click.prevent="selectValue(item)" class="select-box__variant-item">{{ getDisplayValue(item) }}</li>
                </ul>
            </div>

            <div v-if="showOptions && isMulti && selectedMultiOptions.length > 0" class="search-box__dropdown">
                <ul class="search-box__checkboxes">
                    <label :key="i" v-for="(item, i) in selectedMultiOptions" class="search-box__checkbox checkbox" @click.prevent="selectValue(item)">
                        <input :disabled="isDisabled" type="checkbox" name="checkbox-date" class="checkbox__input" :checked="item.isChecked" @click.prevent="selectValue(item)">
                        <div class="checkbox__content">{{ getDisplayValue(item) }}</div>
                    </label>
                </ul>
            </div>

            <div v-if="madeSearch && showOptions && (isSearchable && filteredOptions.length === 0 || !isSearchable && options.length === 0)" :class="{'search-box__dropdown': isSearchBox, 'select-box__dropdown': !isSearchBox}">
                <div :class="{'search-box__msg': isSearchBox, 'select-box__msg': !isSearchBox}">Нічого не знайдено</div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
