import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/font-awesome.min.css',
                'resources/css/sidebar.min.css',
                // JS
                'resources/js/app.js',
                'resources/js/font-awesome.min.js',
            ],
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
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
