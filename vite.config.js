import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from "@vitejs/plugin-vue"
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    plugins: [
        laravel({
            detectTls: 'rabbi.test',
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    includeAbsolute: false,
                },
            },
        }),
        VitePWA()
    ],
});
