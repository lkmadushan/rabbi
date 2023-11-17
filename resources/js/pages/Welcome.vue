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
                <router-link to="/instructions" class="px-3 py-1.5 md:px-4 md:py-2 space-x-1 flex items-center text-lg bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100">
                    <svg class="w-4 h-4 md:w-6 md:h-6 -rotate-45" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                    </svg>
                    <span>Subscribe</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Welcome'
}
</script>
