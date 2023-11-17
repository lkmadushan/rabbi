<template>
    <div class="flex flex-col flex-1 h-full">
        <div class="px-2 md:px-4 flex flex-col justify-center flex-1 text-center">
            <div class="flex items-center justify-between">
                <button class="p-2 group flex items-center justify-center" type="button">
                    <svg class="w-6 h-6 text-white opacity-50 group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path>
                    </svg>
                </button>
                <div class="sm:w-10/12 xl:w-1/2 mx-auto">
                    <p class="font-serif text-3xl sm:text-4xl lg:text-5xl leading-snug lg:leading-normal">{{ quote }}</p>
                </div>
                <button class="p-2 group flex items-center justify-center" type="button">
                    <svg class="w-6 h-6 text-white opacity-50 group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <portal to="subscribe-button">
        <SubscribeButton />
    </portal>
</template>

<script>
import axios from 'axios'
import SubscribeButton from '../components/SubscribeButton.vue'

export default {
    name: 'Quote',

    components: {
        SubscribeButton
    },

    emits: ['append-classes'],

    data() {
        return {
            quote: '',
        };
    },

    mounted() {
        this.getQuote()

        this.$emit('append-classes', 'bg-[url(\'profile.png\')]')
    },

    beforeUnmount() {
        this.$emit('append-classes', '')
    },

    methods: {
        getQuote() {
            axios.get('/quote').then(response => {
                this.quote = response.data.content
            });
        },
    },
}
</script>
