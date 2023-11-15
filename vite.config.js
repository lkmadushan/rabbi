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
            'YzcyNTgzMjMtZmI3OS00YmQzLTg2YzktZWFkMWIzNjliOGQ2',
            '51fdf5c5-a9a3-42b7-94a6-36067d273cf7',
             false
        ),
    ],
});
