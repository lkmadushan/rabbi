import './bootstrap'
import { createApp } from 'vue'
import App from './pages/App.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'
import router from './routes/index.js'

const app = createApp(App)

app.use(OneSignalVuePlugin, {
    appId: import.meta.env.VITE_ONESIGNAL_APP_ID,
    allowLocalhostAsSecureOrigin: true,
})

app.use(router)

app.mount('#app')
