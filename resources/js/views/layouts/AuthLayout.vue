<script setup lang="ts">
import {ShieldCheck} from "lucide-vue-next"

const props = defineProps({
    title: {
        required: true,
        type: String
    },
    description: {
        required: true,
        type: String
    }
})
</script>

<template>
    <div class="bg-background text-foreground min-h-screen flex flex-col font-sans">

        <!-- Main Content Area with Decorative Blur Overlays -->
        <main class="flex-grow flex items-center justify-center py-brand-xl px-brand-md relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-64 h-64 rounded-full bg-secondary/5 blur-2xl pointer-events-none"></div>

            <div class="w-full max-w-[540px] z-10">

                <!-- Branding Header -->
                <div class="flex flex-col items-center mb-brand-md text-center">
                    <div class="w-20 h-20 bg-primary rounded-lg flex items-center justify-center mb-brand-base shadow-ambient">
                        <img
                            alt="Republic of Cyprus Coat of Arms"
                            class="w-14 h-14 object-contain"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCO_9Ex9p-Yf02WcifXFuj5ZRc78D_gdRaNEaFNTCQU9s7W_W-ZJZhK_w8yXULnJTaTmxIECkCMdYiqWMSu4TcqUrOqQGP98QGwWuLHlSEXi0oh_0Q16dBlnoiQoea20-XmREKPM5vZi20ceUKMzpxh0bpuVUcSM0FiuU3vRJHzmnLVvkCjl8ePJ0_UAH633wu7RKxzzBee_E0vB0mpIdhFJ5ND8riK9BD5vRwu4xf6VwkTQ43csbc5Kjvar5ep1BrmdwapoON2iEg"
                        />
                    </div>
                    <h1 class="text-3xl font-heading tracking-tight text-primary font-bold">{{ $t("auth." + title) }}</h1>
                    <p class="text-sm text-muted-foreground mt-1 max-w-sm">
                        {{ $t("auth." + description) }}
                    </p>
                </div>

                <!-- Registration Layout Container -->
                <div class="bg-card/95 backdrop-blur-md p-brand-md md:p-brand-lg rounded-md border border-neutral-200/60 shadow-ambient">
                    <slot />
                </div>

                <!-- Trust Infrastructure & Regulatory Policy Footer -->
                <div class="mt-brand-md flex flex-col items-center gap-3">
                    <div class="flex items-center gap-1.5 text-neutral-400">
                        <ShieldCheck class="h-4 w-4" />
                        <span class="text-xs font-medium tracking-wide">Secured by CY State Encryption Standards</span>
                    </div>
                    <div class="flex gap-4 text-xs text-neutral-400 font-medium">
                        <a href="#" class="hover:text-primary underline decoration-neutral-300">Privacy Policy</a>
                        <a href="#" class="hover:text-primary underline decoration-neutral-300">Terms of Service</a>
                    </div>
                </div>

            </div>
        </main>

        <!-- Structural Layout System Footer Component -->
        <footer class="bg-neutral-50 border-t border-neutral-200/80 flex flex-col md:flex-row justify-between items-center py-4 px-brand-md gap-4">
            <div>
                <span class="text-sm font-semibold text-neutral-800 tracking-wide font-heading">Π.Ε.ΚΥ.ΔΗ</span>
            </div>
            <p class="text-xs text-neutral-500 text-center md:text-left">
                © 2026 Michael Konstantinou. All rights reserved.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="text-xs text-neutral-500 hover:text-primary underline transition-colors">Privacy Policy</a>
                <a href="#" class="text-xs text-neutral-500 hover:text-primary underline transition-colors">Terms of Service</a>
            </div>
        </footer>

    </div>
</template>

<style scoped>

</style>
