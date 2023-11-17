<template>
    <div class="flex flex-col flex-1 h-screen font-sans bg-black text-white text-sm bg-[url('profile.png')] bg-[length:900px] md:bg-auto bg-no-repeat bg-bottom bg-cover]">
        <Header></Header>
        <Quote></Quote>
        <Instructions></Instructions>
        <Footer></Footer>
    </div>
</template>
<script>
import Header from './Header.vue'
import Footer from './Footer.vue'
import Instructions from './Instructions.vue'
import Quote from './Quote.vue'

export default {
    components: {
        Quote,
        Header,
        Footer,
        Instructions
    }
}
</script>
