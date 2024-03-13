<template>
    <div class="px-3 py-10 md:px-20 md:py-16">
        <div class="flex justify-center flex-col">
            <SubscribeButton :is-subscribed="isSubscribed" @request-permission="requestPermission" class="mb-10 flex justify-center"/>
            <div class="flex justify-center">
                <img :src="asset('quote.png')" alt="quotes" class="w-auto h-16 md:h-16">
            </div>
        </div>
    </div>

    <button @click="getPrevQuote" class="p-2 group flex items-center justify-center fixed top-[50%]" type="button">
        <svg class="w-8 h-8 text-white opacity-50 group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
        </svg>
    </button>
    <div class="px-2 md:px-4 flex flex-col justify-center flex-1 text-center mx-10">
        <div class="flex items-center justify-between">
            <div class="sm:w-10/12 xl:w-1/2 mx-auto">
                <p class="font-serif text-3xl sm:text-4xl lg:text-5xl leading-snug lg:leading-normal">{{ quote.content }}</p>
            </div>
        </div>
    </div>
    <button v-if="isPastDate" @click="getNextQuote" class="p-2 group flex items-center justify-center fixed top-[50%] right-0" type="button">
        <svg class="w-8 h-8 text-white opacity-50 group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
        </svg>
    </button>
</template>

<script>
import axios from 'axios'
import SubscribeButton from '../components/SubscribeButton.vue'
import router from '../routes/index.js'

export default {
    name: 'Quote',

    components: {
        SubscribeButton
    },

    data() {
        return {
            quote: {
                date: '',
                content: ''
            },
            isSubscribed: false
        }
    },

    computed: {
        isPastDate() {
            return (new Date(this.quote.date)).toLocaleDateString() < (new Date()).toLocaleDateString()
        }
    },

    async mounted() {
        this.getQuote()

        await this.$OneSignal.User.PushSubscription.optIn()

        this.checkAlreadySubscribed()

        this.$OneSignal.User.PushSubscription.addEventListener("change", this.subscribe)
    },

    methods: {
        getQuote(page = '') {
            axios.get(`/quote?page=${ page }`).then(response => {
                this.quote.content = response.data.content
                this.quote.date = response.data.date
            });
        },

        getNextQuote() {
            this.getQuote('next')
        },

        getPrevQuote() {
            this.getQuote('previous')
        },

        requestPermission() {
            if (this.detectOS() === 'iOS' && !this.isPWA()) {
                return router.push({ name: 'instructions' })
            }

            this.$OneSignal.Slidedown.promptPush({ force: true })
        },

        checkAlreadySubscribed() {
            const user = this.$OneSignal.User.PushSubscription.id

            if (user) {
                this.isSubscribed = true
                this.register(user)
            } else if (this.isPWA()) {
                this.$OneSignal.Slidedown.promptPush({ force: true })
            }
        },

        subscribe(event) {
            if (event.current.optedIn === true) {
                this.isSubscribed = true
                this.register(event.current.id)
            }

            if (event.current.optedIn === false) {
                this.isSubscribed = false
            }
        },

        async register(user) {
            if (user === undefined) {
                return Promise.reject('User is undefined')
            }

            await axios.post('register', { onesignal_id: user })
        },

        isPWA() {
            return window.navigator.standalone === true || // iOS PWA Standalone
                document.referrer.includes('android-app://') || // Android Trusted Web App
                ["fullscreen", "standalone", "minimal-ui"].some(
                    (displayMode) => window.matchMedia('(display-mode: ' + displayMode + ')').matches
                ) // Chrome PWA (supporting fullscreen, standalone, minimal-ui)
        },

        detectOS() {
            let userAgent = window.navigator.userAgent,
                platform = window.navigator.platform,
                macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
                windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
                iosPlatforms = ['iPhone', 'iPad', 'iPod'],
                os = null

            if (macosPlatforms.indexOf(platform) !== -1) {
                os = 'Mac OS'
            } else if (iosPlatforms.indexOf(platform) !== -1) {
                os = 'iOS'
            } else if (windowsPlatforms.indexOf(platform) !== -1) {
                os = 'Windows'
            } else if (/Android/.test(userAgent)) {
                os = 'Android'
            } else if (!os && /Linux/.test(platform)) {
                os = 'Linux'
            }

            return os
        }
    },
}
</script>
