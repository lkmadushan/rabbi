<template>
    <div class="px-3 py-5 md:px-20 md:py-16">
        <div class="flex items-center justify-between">
            <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-left.png" alt="" />

            <button v-if="isSubscribed" type="button" class="pointer-events-none px-3 py-1.5 md:px-4 md:py-2 space-x-1 flex items-center text-sm md:text-lg bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100">
                <svg class="w-4 h-4 md:w-6 md:h-6 -rotate-45" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span>Subscribed</span>
            </button>
            <button v-else @click="requestPermission" type="button" class="px-3 py-1.5 md:px-4 md:py-2 space-x-1 flex items-center text-sm md:text-lg bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100">
                <svg class="w-4 h-4 md:w-6 md:h-6 -rotate-45" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span>Subscribe</span>
            </button>

            <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-right.png" alt="" />
        </div>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            quote: '',
            isSubscribed: false,
        };
    },

    methods: {
        requestPermission() {
            this.$OneSignal.Slidedown.promptPush({ force: true })
        },

        subscribe(event) {
            if(event.current.optedIn === true) {
                this.isSubscribed = true
                this.register(event.current.id)
            }

            if(event.current.optedIn === false) {
                this.isSubscribed = false
            }
        },

        register(user) {
            if (user !== undefined) Promise.reject('User is undefined')

            return axios.post('register', { onesignal_id: user })
        },

        async checkSubscription() {
            await this.$OneSignal.User.PushSubscription.optIn()

            this.isSubscribed = this.$OneSignal.User.PushSubscription.optedIn

            if (this.isSubscribed) {
                this.register(this.$OneSignal.User.PushSubscription.id)
            }
        }
    },

    beforeMount() {
        this.checkSubscription()

        this.$OneSignal.User.PushSubscription.addEventListener("change", this.subscribe)
    },

    beforeUnmount() {
        clearTimeout(this.timeout)
    }
};
</script>
