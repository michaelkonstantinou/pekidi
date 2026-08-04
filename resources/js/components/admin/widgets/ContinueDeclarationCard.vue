<script setup>
import { useI18n } from 'vue-i18n';
import Declaration from "@/models/declaration.js";
import { getLocaleDateDetailedString } from "@/helpers/localeHelpers.js";

const { t } = useI18n();

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

const emit = defineEmits(['continue'])

const handleContinue = () => {
    emit('continue')
}
</script>

<template>
    <div
        class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-slate-900 via-slate-900 to-indigo-950 p-6 text-white shadow-2xl ring-1 ring-white/10 transition-all duration-300 hover:shadow-indigo-500/10 hover:ring-white/20 sm:p-8"
    >
        <!-- Lucide Landmark Watermark Background Icon -->
        <div
            class="pointer-events-none absolute -bottom-10 -right-8 text-white/[0.04] transition-all duration-700 ease-out group-hover:scale-105 group-hover:text-white/[0.07]"
        >
            <svg
                class="h-80 w-80 transform -rotate-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
            >
                <!-- Lucide Landmark SVG Path -->
                <line x1="3" x2="21" y1="22" y2="22"/>
                <line x1="6" x2="6" y1="18" y2="11"/>
                <line x1="10" x2="10" y1="18" y2="11"/>
                <line x1="14" x2="14" y1="18" y2="11"/>
                <line x1="18" x2="18" y1="18" y2="11"/>
                <polygon points="12 2 20 7 4 7 12 2"/>
                <line x1="2" x2="22" y1="11" y2="11"/>
            </svg>
        </div>

        <!-- Ambient Lighting Glows -->
        <div
            class="pointer-events-none absolute -left-20 -top-20 h-72 w-72 rounded-full bg-blue-500/15 blur-3xl transition-opacity duration-500 group-hover:opacity-100"
        ></div>
        <div
            class="pointer-events-none absolute -bottom-20 -right-20 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl transition-opacity duration-500 group-hover:opacity-100"
        ></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 md:flex-row md:items-center">
            <!-- Left Content: Title & Last Updated -->
            <div class="space-y-3">
                <!-- Animated Timestamp Badge -->
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-white/5 px-3.5 py-1 text-xs font-medium text-slate-300 ring-1 ring-inset ring-white/10 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                    </span>
                    <span>{{
                            t('widgets.continue_declaration.last_updated', {date: getLocaleDateDetailedString(declaration.updatedAt)})
                        }}</span>
                </div>

                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                        {{ declaration.name }}
                    </h2>

                    <p class="mt-1.5 text-sm text-slate-300 sm:text-base">
                        {{ t('widgets.continue_declaration.description') }}
                    </p>
                </div>
            </div>

            <!-- Right Content: Action Button -->
            <div class="flex-shrink-0">
                <button
                    type="button"
                    @click="handleContinue"
                    class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition-all hover:bg-blue-500 hover:shadow-blue-500/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 active:scale-[0.98] sm:w-auto"
                >
                    <span>{{ t('widgets.continue_declaration.action_button') }}</span>
                    <svg
                        class="h-4 w-4 transition-transform group-hover:translate-x-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
