<script setup lang="ts">
import {defineProps, reactive, ref, computed} from 'vue';
import {useRules} from 'vuetify/labs/rules';
import {TableHeaderInterface} from "@/js/domain/interfaces/ui/table/TableHeaderInterface";
import {TableDataInterface} from "@/js/domain/interfaces/ui/table/TableDataInterface";
import {apiClient} from "@/js/utilites/apiClient";
import {DataObjectInterface} from "@/js/domain/interfaces/ui/filter/DataObjectInterface";
import {generateUrl, pushHistory} from "@/js/utilites/helpers";

const {data, headers, baseUrl, showActionsColumn = true, showFilter = true, showPaginate = true, filters = {}, idField = 'id'} = defineProps<{
    data: TableDataInterface,
    headers: TableHeaderInterface[],
    baseUrl: string,
    filters?: DataObjectInterface,
    showActionsColumn?: boolean,
    showFilter?: boolean,
    showPaginate?: boolean,
    idField?: string,
}>()

const pageData = reactive({
    ...data,
});

const filterData = reactive({
    search: '',
    ...filters,
});

const currentPage = ref(data?.current_page || 1);

const paginator = computed(() => {
    const { data, ...paginator } = pageData;

    return paginator;
});

const pageFilterForm = ref();
const rules = useRules();

async function loadData(): Promise<void> {
    const sendData = {
        page: currentPage.value,
        ...filterData
    };
    const { data } = await apiClient.get(baseUrl, sendData);

    const url = generateUrl(baseUrl, sendData);
    pushHistory(url);

    Object.keys(data).forEach((key) => {
        pageData[key] = data[key];
    });
}

async function onPage(page: number) {
    currentPage.value = page;

    await loadData();
}

async function onSearch() {
    const { valid } =  await pageFilterForm.value.validate();

    if (valid) {
        currentPage.value = 1;
        await loadData();
    }
}

</script>

<template>
    <div>
        <div v-if="showFilter">
            <v-form ref="pageFilterForm" @submit.prevent="onSearch">
                <div v-if="$slots.filter">
                    <slot name="filter" :filterData="filterData"></slot>
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
        <div v-if="$slots.table">
            <slot name="table" :headers="headers" :data="data" :base-url="baseUrl"></slot>
        </div>
        <div v-else>
            <table class="table w-100">
                <thead>
                    <tr>
                        <th v-for="headerItm in headers">
                            <div v-if="$slots[`header_${headerItm.name}`]">
                                <slot :name="`header_${headerItm.name}`" :header="headerItm.title" :headers="headers" :data="data"></slot>
                            </div>
                            <div v-else>
                                {{ headerItm.title }}
                            </div>
                        </th>
                        <th v-if="showActionsColumn"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in pageData.data">
                        <td v-for="headerItm in headers">
                            <div v-if="row[headerItm.name]">
                                <div v-if="$slots[`data_${headerItm.name}`]">
                                    <slot :name="`data_${headerItm.name}`" :row-index="index" :data-item="row[headerItm.name]" :row="row" :headers="headers" :header="headerItm.title" :data="data"></slot>
                                </div>
                                <div v-else>
                                    {{ row[headerItm.name] }}
                                </div>
                            </div>
                        </td>
                        <td v-if="showActionsColumn">
                            <div v-if="$slots.actions">
                                <slot name="actions" :row-index="index" :row="row" :headers="headers" :data="data"></slot>
                            </div>
                            <div v-else>
                                <a :href="`${baseUrl}/${row[idField]}/edit`"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a :href="`${baseUrl}/${row[idField]}/delete`"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="showPaginate">
            <paginate @page="onPage" :paginator="paginator"></paginate>
        </div>
    </div>
</template>

<style scoped>

</style>
