<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { Scale, ExternalLink, FileText } from 'lucide-vue-next';

const { t } = useI18n();

defineProps({
    lawUrl: {
        type: String,
        default: 'https://www.example-gov.gr/law/asset-declarations',
    },
    officialFormUrl: {
        type: String,
        default: 'https://www.example-gov.gr/forms/asset-declaration-template.pdf',
    },
});
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

        <!-- Background Watermark Icon: Tinted Primary Scale of Justice -->
        <div
            class="pointer-events-none absolute -bottom-6 -right-6 text-primary/10 transition-all duration-500 group-hover:scale-105 group-hover:text-primary/15 dark:text-primary/[0.08] dark:group-hover:text-primary/[0.12]"
        >
            <Scale class="h-64 w-64 transform -rotate-12" />
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <!-- Lucide Scale Badge Icon -->
                <div class="-mt-1.5 inline-flex items-center justify-center rounded-lg bg-primary/10 p-2.5 text-primary ring-1 ring-inset ring-primary/20 dark:bg-primary/20 dark:text-primary-foreground dark:ring-primary/30">
                    <Scale class="h-5 w-5 dark:text-white" />
                </div>

                <div>
                    <h3 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-2xl">
                        {{ t('widgets.compliance_info.title') }}
                    </h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600 dark:text-slate-300 sm:text-base">
                        {{ t('widgets.compliance_info.description') }}
                    </p>
                </div>
            </div>

            <!-- Action Links Stack -->
            <div class="flex flex-col gap-2.5 pt-2 sm:flex-row sm:items-center">
                <!-- Law Reference Link -->
                <a
                    :href="lawUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group/link inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-800 transition-all hover:bg-primary/10 hover:text-primary dark:bg-slate-700/60 dark:text-slate-200 dark:hover:bg-primary/20 dark:hover:text-white"
                >
                    <Scale class="h-4 w-4 text-slate-500 transition-colors group-hover/link:text-primary dark:text-slate-400 dark:group-hover/link:text-white" />
                    <span>{{ t('widgets.compliance_info.law_link') }}</span>
                    <ExternalLink class="h-3.5 w-3.5 opacity-60 transition-transform group-hover/link:translate-x-0.5" />
                </a>

                <!-- Official Form Link -->
                <a
                    :href="officialFormUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group/link inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-800 transition-all hover:bg-primary/10 hover:text-primary dark:bg-slate-700/60 dark:text-slate-200 dark:hover:bg-primary/20 dark:hover:text-white"
                >
                    <FileText class="h-4 w-4 text-slate-500 transition-colors group-hover/link:text-primary dark:text-slate-400 dark:group-hover/link:text-white" />
                    <span>{{ t('widgets.compliance_info.form_link') }}</span>
                    <ExternalLink class="h-3.5 w-3.5 opacity-60 transition-transform group-hover/link:translate-x-0.5" />
                </a>
            </div>
        </div>
    </div>
</template>
