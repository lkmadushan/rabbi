import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'

const app = createApp(App)

app.use(OneSignalVuePlugin, {
    appId: import.meta.env.VITE_ONESIGNAL_APP_ID,
    allowLocalhostAsSecureOrigin: true,
})

app.mount('#app')
