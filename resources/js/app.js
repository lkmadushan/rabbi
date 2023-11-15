import './bootstrap';
import { createApp } from 'vue';
import Quote from './components/Quote.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'

createApp(Quote).use(OneSignalVuePlugin, {
    appId: "51fdf5c5-a9a3-42b7-94a6-36067d273cf7",
    promptOptions: {
        autoPrompt: false,
    },
    allowLocalhostAsSecureOrigin: true,
}).mount('#app')
