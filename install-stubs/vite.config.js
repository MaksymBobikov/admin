import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    build: {
        minify: true,
    },
    define: {
        envData: JSON.stringify({APP_URL: dotenv.config().parsed.APP_URL})
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/admin/js'),
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/admin/css/app.css', 'resources/admin/js/app.js'],
            refresh: true,
        }),
    ],
});
