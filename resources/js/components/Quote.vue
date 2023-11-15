<template>
    <div
        class="container mx-auto fixed top-0 left-0 w-full h-full max-w-full bg-cover bg-center"
    >
        <div
            class="px-4 py-8 bg-black bg-opacity-60 w-full h-full max-w-full overflow-auto"
        >
            <div class="header grid grid-cols-3 gap-4 mb-14">
                <div class="flex items-center justify-center">
                    <img src="../../assets/logo.png"/>
                </div>
                <div class="flex items-center justify-center">
                    <button
                        v-if="isSubscribed"
                        class="flex items-center justify-center bg-[#622a7d] hover:bg-[#7a499b] text-white font-bold py-2 px-4 rounded-full"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 ml-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12H5"
                            />
                        </svg>
                        Subscribed
                    </button>
                    <button
                        v-else
                        class="flex items-center justify-center bg-[#622a7d] hover:bg-[#7a499b] text-white font-bold py-2 px-4 rounded-full"
                        @click="requestPermission"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 ml-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12H5"
                            />
                        </svg>
                        Subscribe
                    </button>
                </div>
                <div class="flex items-center justify-center">
                    <img class="rotate-180" src="../../assets/logo.png"/>
                </div>
            </div>
            <div class="flex flex-col items-center mb-14">
                <div class="mt-4 text-white text-center w-3/4" v-if="quote">
                    <div class="rounded p-4">
                        <p class="text-lg font-semibold text-4xl font-serif">
                            {{ quote }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer flex flex-col items-center">
                <div class="rounded p-4 w-13 text-white text-center">
                    <img src="../../assets/sign.png"/>
                    <div class="text">
                        <p>Find out more</p>
                        <p>www.rabbisacks.org</p>
                    </div>
                </div>
            </div>
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
        getQuote() {
            axios.get('api/quote').then(response => {
                this.quote = response.data.content
            });
        },

        async requestPermission() {
            let x = await this.$OneSignal.Slidedown.promptPush({ force: true })
            console.log(x)
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
            if (user !== undefined) {
                axios.post('api/register', { userId: user })
            }
        },

        checkUserSubscribed() {
            this.timeout = setTimeout(
                () => {
                    this.isSubscribed = this.$OneSignal.Notifications.permission
                },
                3200
            )
        }
    },

    mounted() {
        this.getQuote()
        this.checkUserSubscribed()
        //this.$OneSignal.Debug.setLogLevel('trace')

        this.$OneSignal.User.PushSubscription.addEventListener("change", this.subscribe)
    },

    beforeUnmount() {
        // clearTimeout(this.timeout)
    }
};
</script>

<style scoped>
.quote-card {
    background-color: #fff;
    border: 1px solid #ddd;
    margin-bottom: 10px;
}

.quote-text {
    font-size: 16px;
    line-height: 1.5;
}

.quote-author {
    font-size: 14px;
    font-style: italic;
}

.container {
    background-image: url("https://media.rabbisacks.org/20211118135814/portrait-of-rabbi-lord-jonathan-sacks-wearing-pink-tie-800x620.jpg");
    background-size: cover;
    background-position: center;
}

.header img {
    width: 5vw;
}

.footer .text {
    margin-top: -0px;
}

.footer img {
    width: 30vw;
}
</style>
