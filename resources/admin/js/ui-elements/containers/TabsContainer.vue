<script setup lang="ts">
import {defineProps, ref} from 'vue';
import {TabItemInterface} from "@/js/domain/interfaces/ui/tabs/TabItemInterface";

const tab = ref(null);

const {tabs,
} = defineProps<{
    tabs: TabItemInterface[],
}>()
</script>

<template>
    <div>
        <v-tabs
            v-model="tab"
            align-tabs="center"
            color="deep-purple-accent-4"
        >
            <v-tab v-for="tabItem in tabs" :value="tabItem.name">{{ tabItem.title }}</v-tab>
        </v-tabs>

        <v-tabs-window v-model="tab">
            <v-tabs-window-item
                v-for="(tabItem, i) in tabs"
                :key="i"
                :value="tabItem.name"
            >
                <v-container fluid>
                    <div v-if="$slots[tabItem.name]">
                        <slot :name="tabItem.name"></slot>
                    </div>
                    <div v-else></div>
                </v-container>
            </v-tabs-window-item>
        </v-tabs-window>
    </div>
</template>

<style scoped>

</style>
