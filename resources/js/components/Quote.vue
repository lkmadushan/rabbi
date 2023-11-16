<template>
    <div class="sm:w-10/12 xl:w-1/2 mx-auto px-4 flex flex-col justify-center flex-1 text-center">
        <p class="font-serif text-3xl sm:text-4xl lg:text-5xl md:leading-snug lg:leading-snug">{{ quote }}</p>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            quote: '',
        };
    },

    methods: {
        getQuote() {
            axios.get('api/quote').then(response => {
                this.quote = response.data.content
            });
        },
    },

    mounted() {
        this.getQuote()
    }
};
</script>
