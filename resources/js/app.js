import './bootstrap'
import { createApp } from 'vue'
import vapor from 'laravel-vapor'
import App from './components/App.vue'
import OneSignalVuePlugin from '@onesignal/onesignal-vue3'
import router from './routes/index.js'

window.Vapor = vapor
Vapor.withBaseAssetUrl(import.meta.env.VITE_VAPOR_ASSET_URL)

const app = createApp(App)

app.use(OneSignalVuePlugin, {
    appId: import.meta.env.VITE_ONESIGNAL_APP_ID,
    allowLocalhostAsSecureOrigin: true,
})

app.mixin({
    methods: {
        asset: window.Vapor.asset
    },
})

app.use(router)

app.mount('#app')
