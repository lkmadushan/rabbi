<template>
    <div class="flex bg-black flex-col flex-1 h-full text-white text-sm bg-[length:900px] md:bg-auto bg-no-repeat bg-bottom bg-cover]" :class="appendClasses">
        <Header/>
        <router-view @append-classes="(name) => className = name"/>
        <Footer/>
    </div>
</template>

<script>
import Header from './Header.vue'
import Footer from './Footer.vue'

export default {
    name: 'Layout',

    components: {
        Header,
        Footer
    },

    data() {
      return {
          className: ''
      }
    },

    computed: {
        appendClasses() {
            return this.className
        }
    }
}
</script>
