import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    define: {
        envData: JSON.stringify({APP_URL: dotenv.config().parsed.APP_URL})
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/admin/css/app.css', 'resources/admin/js/app.js'],
            refresh: true,
        }),
    ],
});
