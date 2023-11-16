import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import {VitePWA} from "vite-plugin-pwa";
import OneSignal from "onesignal";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        VitePWA(),
        OneSignal(
            import.meta.env.VITE_ONESIGNAL_REST_API_KEY,
            import.meta.env.VITE_ONESIGNAL_APP_ID,
            false
        ),
    ],
});
