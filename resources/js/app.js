import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'

createApp(App).use(OneSignalVuePlugin, {
    appId: "51fdf5c5-a9a3-42b7-94a6-36067d273cf7",
    promptOptions: {
        autoPrompt: false,
    },
    allowLocalhostAsSecureOrigin: true,
}).mount('#app')
