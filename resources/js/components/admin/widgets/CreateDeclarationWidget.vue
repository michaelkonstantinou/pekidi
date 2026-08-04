<script setup>
import { useI18n } from 'vue-i18n';
import { Plus } from 'lucide-vue-next';

const { t } = useI18n();

const emit = defineEmits(['create']);

const handleCreate = () => {
    emit('create');
};
</script>

<template>
    <div
        class="group relative flex h-full flex-col justify-between overflow-hidden rounded-xl bg-white p-6 text-slate-900 shadow-xl ring-1 ring-slate-900/5 transition-shadow duration-300 hover:shadow-2xl hover:shadow-primary/15 dark:bg-slate-800/80 dark:text-white dark:ring-white/10 dark:hover:shadow-primary/20 sm:p-8"
    >
        <!-- Soft Primary Ambient Lighting Glows -->
        <div
            class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-primary/10 blur-3xl transition-opacity duration-500 group-hover:opacity-100 dark:bg-primary/20"
        ></div>
        <div
            class="pointer-events-none absolute -bottom-16 -left-16 h-56 w-56 rounded-full bg-primary/5 blur-3xl transition-opacity duration-500 group-hover:opacity-100 dark:bg-primary/15"
        ></div>

        <!-- Background Watermark Icon: Tinted Primary -->
        <div
            class="pointer-events-none absolute -bottom-6 -right-6 text-primary/10 transition-all duration-500 group-hover:scale-105 group-hover:text-primary/15 dark:text-primary/[0.08] dark:group-hover:text-primary/[0.12]"
        >
            <svg
                class="h-64 w-64 transform rotate-6"
                fill="none"
                stroke="currentColor"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
                viewBox="0 0 24 24"
            >
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="12" y1="18" x2="12" y2="12" />
                <line x1="9" y1="15" x2="15" y2="15" />
            </svg>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <!-- Lucide Plus Badge Icon -->
                <div class="-mt-1.5 inline-flex items-center justify-center rounded-lg bg-primary/10 p-2.5 text-primary ring-1 ring-inset ring-primary/20 dark:bg-primary/20 dark:text-primary-foreground dark:ring-primary/30">
                    <Plus class="h-5 w-5 dark:text-white" />
                </div>

                <div>
                    <h3 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                        {{ t('widgets.create_declaration.title') }}
                    </h3>
                    <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-300 sm:text-base">
                        {{ t('widgets.create_declaration.description') }}
                    </p>
                </div>
            </div>

            <!-- Primary Color Action Button -->
            <div class="pt-2">
                <button
                    type="button"
                    @click="handleCreate"
                    class="group/btn inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/30 transition-all hover:bg-primary/90 hover:shadow-primary/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:scale-[0.98] sm:w-auto"
                >
                    <span>{{ t('widgets.create_declaration.action_button') }}</span>
                    <svg
                        class="h-4 w-4 transition-transform group-hover/btn:translate-x-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
