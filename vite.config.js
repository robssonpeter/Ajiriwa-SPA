import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
    build: {
        outDir: 'public/js',
        rollupOptions: {
            main: 'resources/js/app.js',
            extraFile1: 'resources/js/apply.js',
            extraFile2: 'resources/js/essential.js',
            extraFile3: 'resources/js/homepage.js',
            extraFile4: 'resources/js/job.js',
        }
    }
});
