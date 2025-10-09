<script setup lang="ts">
    import { ref } from 'vue';
    import menuData from '@/js/menu.json';

    const menu = ref(menuData);
</script>
<template>
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="mb-4">Admin Panel</h4>
        <ul class="nav nav-pills flex-column">
            <li v-for="menuItem in menu" class="nav-item">
                <a class="nav-link active" :href="menuItem?.url ? menuItem.url : '#'">{{ menuItem.title}}</a>
                <div v-if="menuItem?.items">
                    <ul class="list-unstyled ps-3">
                        <li v-for="subItem in menuItem.items"><a :href="subItem?.url ? subItem.url : '#'" class="nav-link">{{ subItem.title}}</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</template>
