<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { ExternalLink, Sparkles } from 'lucide-vue-next';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from '@/components/ui/carousel';

const { t } = useI18n();

interface Product {
    id: string;
    logoUrl: string;
    titleKey: string;
    descriptionKey: string;
    badgeKey?: string;
    url: string;
}

// Product list with logo support
const products: Product[] = [
    {
        id: 'workfolio',
        logoUrl: '/images/workfolio_architect.webp', // Path to your logo image
        titleKey: 'widgets.products.workfolio_architect.title',
        descriptionKey: 'widgets.products.workfolio_architect.description',
        badgeKey: 'widgets.products.badges.best_seller',
        url: 'https://workfolio-architect.com',
    },
    {
        id: 'tax_suite',
        logoUrl: '/images/logos/tax-suite.png',
        titleKey: 'widgets.products.tax_suite.title',
        descriptionKey: 'widgets.products.tax_suite.description',
        badgeKey: 'widgets.products.badges.featured',
        url: 'https://example.com/tax-suite',
    },
    {
        id: 'audit_vault',
        logoUrl: '/images/logos/audit-vault.png',
        titleKey: 'widgets.products.audit_vault.title',
        descriptionKey: 'widgets.products.audit_vault.description',
        badgeKey: 'widgets.products.badges.coming_soon',
        url: 'https://example.com/audit-vault',
    },
    {
        id: 'audit_vault',
        logoUrl: '/images/logos/audit-vault.png',
        titleKey: 'widgets.products.audit_vault.title',
        descriptionKey: 'widgets.products.audit_vault.description',
        url: 'https://example.com/audit-vault',
    },
];
</script>

<template>
    <div class="space-y-4">
<!--        &lt;!&ndash; Header Section &ndash;&gt;-->
<!--        <div class="flex items-center justify-between px-1">-->
<!--            <div class="flex items-center gap-2">-->
<!--                <div class="rounded-lg bg-primary/10 p-1.5 text-primary dark:bg-primary/20 dark:text-white">-->
<!--                    <Sparkles class="h-4 w-4" />-->
<!--                </div>-->
<!--                <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">-->
<!--                    {{ t('widgets.products.section_title') }}-->
<!--                </h2>-->
<!--            </div>-->
<!--            <p class="hidden text-xs text-slate-500 dark:text-slate-400 sm:block">-->
<!--                {{ t('widgets.products.section_subtitle') }}-->
<!--            </p>-->
<!--        </div>-->

        <!-- shadcn-vue Carousel Container -->
        <Carousel
            class="relative w-full"
        >
            <CarouselContent class="-ml-4">
                <CarouselItem
                    v-for="product in products"
                    :key="product.id"
                    class="pl-4 md:basis-1/2 lg:basis-1/3"
                >
                    <div
                        class="group relative flex h-full flex-col justify-between overflow-hidden rounded-xl bg-white p-6 shadow-md ring-1 ring-slate-900/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10 dark:bg-slate-800/80 dark:ring-white/10 dark:hover:shadow-primary/20"
                    >
                        <!-- Ambient Background Glow -->
                        <div
                            class="pointer-events-none absolute -right-12 -top-12 h-36 w-36 rounded-full bg-primary/5 blur-2xl transition-opacity duration-300 group-hover:opacity-100 dark:bg-primary/15"
                        ></div>

                        <div class="relative z-10 space-y-4">
                            <!-- Top Row: Logo Container + Optional Badge -->
                            <div class="relative">
                                <!-- Optional Badge positioned top-right -->
                                <div v-if="product.badgeKey" class="absolute right-3 top-3 z-20">
  <span
      class="inline-flex items-center gap-1 rounded-full bg-primary px-3 py-1 text-xs font-bold text-white shadow-md shadow-primary/20 ring-1 ring-white/20 backdrop-blur-md transition-transform duration-300 group-hover:scale-105"
  >
    <Sparkles class="h-3 w-3" />
    {{ t(product.badgeKey) }}
  </span>
                                </div>

                                <!-- Fully Expanded Hero Logo Box -->
                                <div class="flex h-56 w-full items-center justify-center overflow-hidden rounded-lg p-1 ring-1 ring-slate-900/5 transition-all group-hover:bg-white bg-white">
                                    <img
                                        :src="product.logoUrl"
                                        :alt="t(product.titleKey)"
                                        class="h-full w-full object-contain filter transition-transform duration-300 group-hover:scale-105"
                                    />
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                                    {{ t(product.titleKey) }}
                                </h3>
                                <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-slate-600 dark:text-slate-300">
                                    {{ t(product.descriptionKey) }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Link Button -->
                        <div class="relative z-10 pt-5">
                            <a
                                :href="product.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group/btn inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-4 py-2.5 text-xs font-semibold text-slate-800 transition-all hover:bg-primary hover:text-white dark:bg-slate-700/60 dark:text-slate-200 dark:hover:bg-primary dark:hover:text-white"
                            >
                                <span>{{ t('labels.learn_more') }}</span>
                                <ExternalLink class="h-3.5 w-3.5 transition-transform group-hover/btn:translate-x-0.5" />
                            </a>
                        </div>
                    </div>
                </CarouselItem>
            </CarouselContent>

            <!-- Navigation Arrows -->
            <div class="mt-4 flex items-center justify-end gap-2 pr-1">
                <CarouselPrevious class="static translate-y-0 text-slate-600 hover:bg-primary/10 hover:text-primary dark:text-slate-300" />
                <CarouselNext class="static translate-y-0 text-slate-600 hover:bg-primary/10 hover:text-primary dark:text-slate-300" />
            </div>
        </Carousel>
    </div>
</template>
