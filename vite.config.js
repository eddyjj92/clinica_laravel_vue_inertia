import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@use "~/resources/css/index.scss" as *;`,
            },
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css","resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
