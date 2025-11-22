<script setup lang="ts">
import {defineProps, ref} from 'vue';

const showDialog = defineModel('modelValue', { required: false, default: false });

const {maxWidth = 500,
} = defineProps<{
    maxWidth?: number,
}>()

</script>

<template>
    <div class="text-center pa-4">
        <v-dialog
            v-model="showDialog"
            width="auto"
        >
            <v-card
                :max-width="maxWidth"
            >
                <template>
                    <slot></slot>
                </template>
                <template v-slot:actions>
                    <slot name="actions"></slot>
                </template>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>

</style>
