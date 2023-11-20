<template>
    <div class="flex bg-black flex-col flex-1 h-full text-white text-sm bg-[length:900px] md:bg-auto bg-no-repeat bg-bottom bg-cover]" :class="classes">
        <div class="px-3 py-5 md:px-20 md:py-16">
            <div class="flex items-center justify-between">
                <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-left.png" alt="" />
                <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-right.png" alt="" />
            </div>
        </div>
        <router-view/>
        <div class="px-4 py-10 text-center">
            <img class="w-auto h-16 lg:h-24 mt-3 mb-1 inline-flex" src="/quote.png" alt="" />
            <p>Find out more <br /><a class="outline-0 hover:underline focus:underline" href="https://rabbisacks.org">www.rabbisacks.org</a></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Layout',

    data() {
      return {
          className: ''
      }
    },

    computed: {
        classes() {
            return this.$route.name === 'Quotes' ? 'bg-rabbisacks' : ''
        }
    }
}
</script>
