<template>
    <div class="px-4 md:flex mx-auto flex-1 md:space-x-4 space-y-8 md:space-y-0">
        <div class="md:w-1/3">
            <div class="xl:w-1/2 mx-auto space-y-6">
                <p class="text-lg md:text-2xl">Welcome to <br class="hidden md:block" /><span class="font-bold">‘Chiefly Quotes’</span></p>
                <p class="text-lg md:text-2xl">Your way to receive inspirational quotes from <span class="font-bold">Rabbi Sacks</span> straight to your mobile phone every day.</p>
            </div>
        </div>

        <div class="md:w-2/3 space-y-2 text-lg md:text-2xl">
            <p>Instructions for installing the app (iOS)</p>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 1:</div>
                <div class="flex flex-1">
                    <div class="mr-2">Click ‘share button’</div>
                    <button type="button" class="pointer-events-none w-8 h-8 -mt-0.5 group flex items-center justify-center bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none"/><path fill="currentColor" d="M16 5l-1.42 1.42-1.59-1.59V16h-1.98V4.83L9.42 6.42 8 5l4-4 4 4zm4 5v11c0 1.1-.9 2-2 2H6c-1.11 0-2-.9-2-2V10c0-1.11.89-2 2-2h3v2H6v11h12V10h-3V8h3c1.1 0 2 .89 2 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 2:</div>
                <div class="md:inline-flex flex-1">
                    <span class="mr-2">Scroll down and click</span>
                    <button type="button" class="pointer-events-none px-2.5 py-0.5 flex items-center bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100 inline-flex">
                        <span class="text-sm">Add to Home Screen</span>
                    </button>
                </div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 3:</div>
                <div class="md:inline-flex flex-1">
                    <span class="mr-2">Review settings and click</span>
                    <button type="button" class="pointer-events-none px-2.5 py-0.5 flex items-center bg-primary text-white hover:bg-white hover:text-primary focus:outline-0 focus:ring-2 focus:ring-white rounded-full transition delay-100 inline-flex">
                        <span class="text-sm">Add</span>
                    </button>
                </div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 4:</div>
                <div class="flex flex-1 md:inline">Launch the app from your home screen</div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 5:</div>
                <div class="flex flex-1 md:inline">Click the Subscribe button</div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 6:</div>
                <div class="flex flex-1 md:inline">A request to allow notifications will pop up, click allow</div>
            </div>
            <div class="space-x-1.5 flex">
                <div class="text-primary whitespace-nowrap">Step 7:</div>
                <div class="flex flex-1 md:inline">You should immediately receive your first quote</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'instructions',
}
</script>
