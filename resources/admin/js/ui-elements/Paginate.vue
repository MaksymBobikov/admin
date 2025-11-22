<script setup lang="ts">
import {defineProps, computed, defineEmits} from 'vue';
import {PaginateDataInterface} from "@/js/domain/interfaces/ui/table/PaginateDataInterface";

const emit = defineEmits(['page']);

const { paginator } = defineProps<{
    paginator: PaginateDataInterface,
}>()

const pageLinks = computed(() => paginator.links.filter( itm => +itm.label > 0));
const currentPage = computed(() => paginator.current_page);

function selectPage(page: number) {
    emit('page', page);
}

</script>

<template>
    <nav class="pagination" aria-label="Paginate">
        <button class="prev" :disabled="!paginator.first_page_url && paginator.current_page < 2" @click.prevent="selectPage(currentPage - 1)">‹ Prev</button>

        <a href="#" v-for="pageItem in pageLinks" @click.prevent="selectPage(+pageItem.label)" :class="{'active': +pageItem.label === paginator.current_page} ">{{ pageItem.label }}</a>

        <button class="next" :disabled="!paginator.next_page_url" @click.prevent="selectPage(currentPage + 1)">Next ›</button>
    </nav>
</template>

<style scoped>

</style>
