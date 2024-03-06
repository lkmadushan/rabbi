<template>
    <div class="flex bg-secondary flex-col text-white h-full text-sm bg-no-repeat mt-auto bg-[length:600px] bg-center" :class="classes">
        <router-view/>
        <div class="px-4 py-10 text-center">
            <img class="w-auto h-16 lg:h-24 mt-3 mb-1 inline-flex" :src="asset('signature.png')" alt="signature" />
            <p>Find more at <br /><a class="outline-0 hover:underline focus:underline" href="https://rabbisacks.org" target="_blank">www.rabbisacks.org</a></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Layout',

    computed: {
        classes() {
            return this.$route.name === 'quotes' ? 'bg-rabbisacks' : ''
        }
    }
}
</script>
