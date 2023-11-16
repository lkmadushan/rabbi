import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'

createApp(App).use(OneSignalVuePlugin, {
    appId: import.meta.env.VITE_ONESIGNAL_APP_ID,
    promptOptions: {
        autoPrompt: false,
    },
    allowLocalhostAsSecureOrigin: true,
}).mount('#app')
