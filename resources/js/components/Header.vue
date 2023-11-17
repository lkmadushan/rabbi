<template>
    <div class="px-3 py-5 md:px-20 md:py-16">
        <div class="flex items-center justify-between">
            <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-left.png" alt="" />

            <portal-target name="subscribe-button" />

            <img class="w-12 h-12 md:w-20 md:h-20" src="/quote-right.png" alt="" />
        </div>
    </div>
</template>

<script>
export default {
    name: 'Header'
}
</script>
