<script setup lang="ts">
import { watch } from 'vue';
import { snackbarModel } from '@/store/common/snackbarModel.js';
import { useColorSnackbar, useShowSnackbar, useTextSnackbar } from '@/composable/useShowSnackbar';

const showSnackbar = useShowSnackbar();
const snackbarText = useTextSnackbar();
const snackbarColor = useColorSnackbar();

function closeSnackbar() {
    snackbarModel.show = false
}

watch(showSnackbar, (newValue) => {
    if (newValue) {
        setTimeout(() => { closeSnackbar();}, 2000);
    }
})

</script>

<template>
    <v-snackbar v-model="showSnackbar" :color="snackbarColor">
        {{ snackbarText }}

        <template v-slot:actions>
            <span class="close-snackbar-btn" @click="closeSnackbar">X</span>
        </template>
    </v-snackbar>
</template>

<style scoped>
.close-snackbar-btn {
    cursor: pointer;
    margin-right: 10px;
    color: black;
}
</style>
