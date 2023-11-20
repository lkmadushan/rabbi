<template>
    <div class="w-3/5 mx-auto flex flex-col flex-1 justify-center">
        <div class="space-y-5 text-center">
            <p class="text-lg md:text-2xl">
                Welcome to
                <br class="hidden md:block">
                <span class="font-bold">‘Chiefly Quotes’</span>
            </p>
            <p class="text-lg md:text-2xl">
                Your way to receive inspirational quotes from
                <span class="font-bold">Rabbi Sacks</span>
                straight to your mobile phone every day.
            </p>
            <div class="text-lg md:text-2xl">
                All you have to do is click subscribe!
            </div>
            <div style="margin-top: 40px" class="flex justify-center">
                <SubscribeButton :is-subscribed="isSubscribed" @request-permission="requestPermission"/>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import SubscribeButton from '../components/SubscribeButton.vue'
import router from '../routes/index.js'
import OneSignal from '@onesignal/onesignal-vue3'

export default {
    name: 'Welcome',

    components: {
        SubscribeButton
    },

    data() {
        return {
            isSubscribed: false
        }
    },

    mounted() {
        this.$OneSignal.User.PushSubscription.optIn()

        this.checkAlreadySubscribed()

        this.$OneSignal.User.PushSubscription.addEventListener("change", this.subscribe)

        this.$OneSignal.Debug.setLogLevel('trace');
    },

    methods: {
        requestPermission() {
            this.$OneSignal.Slidedown.promptPush({ force: true })
        },

        checkAlreadySubscribed() {
            const user = this.$OneSignal.User.PushSubscription.id

            if (user) {
                this.isSubscribed = true
                this.register(user)
            }
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

        async register(user) {
            if (user === undefined) {
                return Promise.reject('User is undefined')
            }

            try {
                await axios.post('register', { onesignal_id: user })

                return router.push({ path: '/instructions' })
            } catch (error) {
                if (error.response.data === 'User already exists') {
                    return router.push({ path: '/quotes' })
                }
            }
        }
    }
}
</script>
