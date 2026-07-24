<script setup lang="ts">
import {Banknote, Info, Building2, CreditCard, Download, Landmark, Printer, Wallet} from 'lucide-vue-next'
import {Button} from '@/components/ui/button'
import Declaration from "@/models/declaration";
import HeadingSmall from "@/components/HeadingSmall.vue";
import {computed, onMounted, Ref, ref} from "vue";
import DeclarationOverviewService from "@/services/declarationOverviewService";
import {DeclarationOverview} from "@/models/declarationOverview";
import {useErrorMessager} from "@/composables/useErrorMessager";
import {getLocaleCurrencyString} from "@/helpers/localeHelpers";
import DebtToAssetRatioBadge from "@/components/app-ui/declarations/DebtToAssetRatioBadge.vue";
import DeclarationNetWorthOverview from "@/components/app-ui/declarations/DeclarationNetWorthOverview.vue";
import AppSectionHeader from "@/components/app-ui/AppSectionHeader.vue";
import AssetDistributionChartCard from "@/components/app-ui/declarations/AssetDistributionChartCard.vue";

const {toastApiErrors} = useErrorMessager()

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

onMounted(async () => {
    await loadData()
})

const isLoading = ref(false)
const overview: Ref<DeclarationOverview | null> = ref(null)

async function loadData() {
    isLoading.value = true;
    const service = new DeclarationOverviewService()

    try {
        overview.value = await service.getById(props.declaration.id)
    } catch (err) {
        toastApiErrors(err)
    } finally {
        isLoading.value = false;
    }
}

const assetDistribution = [
    { label: 'Real Estate', percentage: '45%', color: 'bg-primary' },
    { label: 'Financials', percentage: '25%', color: 'bg-secondary' },
    { label: 'Business', percentage: '15%', color: 'bg-blue-400' },
    { label: 'Others', percentage: '15%', color: 'bg-slate-300' },
]

const handlePrint = () => {
    window.print()
}
</script>

<template>
    <div class="w-full space-y-6">

        <!-- Summary Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2 border-b border-neutral-100">
            <HeadingSmall title="Overview" description="some info"/>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <Button
                    variant="outline"
                    size="xl"
                    @click="handlePrint"
                >
                    <Printer class="w-4 h-4" />
                    Print
                </Button>

                <Button size="xl">
                    <Download class="w-4 h-4" />
                    Export PDF
                </Button>
            </div>
        </div>

        <div class="space-y-8 mb-8 w-full">



            <!-- Total Assets Section -->
            <div class="p-6 bg-transparent w-full">

                <AppSectionHeader
                    title="Total Assets"
                    :icon="Wallet"
                    variant="primary"
                    :value="getLocaleCurrencyString(overview?.totalAssetsValue ?? 0)"
                />

                <!-- Assets List -->
                <div class="space-y-2.5">
                    <div
                        v-for="item in overview?.getAssets()"
                        :key="item.label"
                        class="group flex justify-between items-center p-3.5 rounded-xl bg-transparent hover:bg-secondary/10 transition-colors duration-200"
                    >
                        <div class="flex items-center gap-4">
                            <!-- Light Secondary Tint Badge -->
                            <div class="w-10 h-10 rounded-lg bg-secondary/20 text-secondary flex items-center justify-center transition-colors group-hover:bg-secondary group-hover:text-secondary-foreground">
                                <component :is="item.icon" class="h-5 w-5 shrink-0" />
                            </div>

                            <div class="flex flex-col justify-center">
                                <span class="text-sm font-semibold text-muted-foreground group-hover:text-foreground transition-colors">
                                    {{ $t(item.label) }}
                                </span>

                                <!-- Units Subtitle (appears/brightens on hover or remains subtle) -->
                                <span
                                    class="text-xs font-medium text-muted-foreground/70 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                >
                                    {{ item.units }} {{ item.units === 1 ? 'unit' : 'units' }}
                                </span>
                            </div>
                        </div>

                        <span class="text-sm font-bold text-foreground">{{ item.amount }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Liabilities Section -->
            <div class="p-6 bg-transparent w-full">
                <AppSectionHeader
                    title="Total Liabilities"
                    :icon="CreditCard"
                    variant="destructive"
                    :value="getLocaleCurrencyString(overview?.totalLiabilitiesValue ?? 0)"
                />

                <!-- Liabilities List -->
                <div class="space-y-2.5">
                    <div
                        v-for="item in overview?.getLiabilities()"
                        :key="item.typeKey"
                        class="group flex justify-between items-center p-3.5 rounded-xl bg-transparent hover:bg-destructive/10 transition-colors duration-200"
                    >
                        <div class="flex items-center gap-4">
                            <!-- Destructive Tint Badge -->
                            <div class="w-10 h-10 rounded-lg bg-destructive/15 text-destructive flex items-center justify-center transition-colors group-hover:bg-destructive group-hover:text-destructive-foreground">
                                <component :is="item.icon" class="h-5 w-5 shrink-0" />
                            </div>

                            <div class="flex flex-col justify-center">
                                <span class="text-sm font-semibold text-muted-foreground group-hover:text-foreground transition-colors">
                                    {{ $t(item.label) }}
                                </span>

                                <!-- Units Subtitle -->
                                <span
                                    class="text-xs font-medium text-muted-foreground/70 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                >
                                    {{ item.units }} {{ item.units === 1 ? 'unit' : 'units' }}
                                </span>
                            </div>
                        </div>

                        <span class="text-sm font-bold text-destructive">{{ item.amount }}</span>
                    </div>

                    <!-- Empty State if no liabilities are present -->
                    <div
                        v-if="!overview?.getLiabilities().length"
                        class="p-6 text-center text-sm font-medium text-muted-foreground bg-neutral-50/50 rounded-xl border border-dashed border-neutral-200"
                    >
                        {{ $t('labels.no_liabilities') }}
                    </div>
                </div>

                <!-- Debt-to-Asset Ratio Pill -->
                <DebtToAssetRatioBadge :overview="overview" />
            </div>

        </div>

        <div class="p-6 bg-transparent w-full">
            <div class="">
                <DeclarationNetWorthOverview :netWorth="overview?.netWorth" />
            </div>
        </div>

        <div class="p-6 bg-transparent w-full">
            <div>
                <AppSectionHeader
                    title="titles.evaluation"
                    :icon="CreditCard"
                    variant="primary"
                />

                <!-- Two-column Grid Container -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
                    <!-- Left: Asset Distribution Card -->
                    <AssetDistributionChartCard :chartData="overview?.assetDistributionChart" />

                    <!-- Right: Your Second Card Goes Here -->
                    <div class="p-6 bg-card border border-neutral-200/80 dark:border-border/50 rounded-default shadow-ambient flex flex-col justify-center items-center">
                        <!-- Placeholder for the upcoming component -->
                        <p class="text-sm text-muted-foreground">
                            Second card placeholder
                        </p>
                    </div>
                </div>
            </div>
        </div>

            <!-- Evaluation Section Grid -->

            <div class="pt-6 border-t border-outline-variant/40">
                <h3 class="text-base font-sans font-bold text-primary mb-4">Evaluation</h3>

                <div class="grid grid-cols-12 gap-5">

                    <!-- Asset Distribution Chart Card -->
                    <div class="col-span-12 lg:col-span-6 p-5 bg-surface-container-low/40 border border-outline-variant/30 rounded-xl flex flex-col items-center">
                        <h4 class="w-full text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">
                            Asset Distribution
                        </h4>

                        <!-- Circular Chart -->
                        <div class="relative w-44 h-44 mb-4 flex items-center justify-center">
                            <div class="w-full h-full rounded-full border-[10px] border-primary border-t-secondary border-r-secondary-container border-b-surface-dim transform -rotate-45"></div>

                            <div class="absolute inset-2 bg-white rounded-full flex flex-col items-center justify-center text-center shadow-inner">
                                <span class="text-[10px] font-semibold text-on-surface-variant uppercase tracking-wider">Liquid</span>
                                <span class="text-2xl font-black text-primary hover:text-secondary transition-colors cursor-pointer">35%</span>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="w-full space-y-2">
                            <div v-for="item in assetDistribution" :key="item.label" class="flex items-center justify-between text-xs px-1">
                                <div class="flex items-center gap-2">
                                    <div :class="['w-2.5 h-2.5 rounded-full', item.color]"></div>
                                    <span class="text-on-surface-variant font-medium">{{ item.label }}</span>
                                </div>
                                <span class="font-bold text-primary">{{ item.percentage }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Summary Card -->
                    <div class="col-span-12 lg:col-span-6 p-5 bg-surface-container-low/40 border border-outline-variant/30 rounded-xl flex flex-col">
                        <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-4">
                            Compliance Summary
                        </h4>

                        <div class="space-y-3">
                            <div class="p-3 bg-white border border-outline-variant/30 rounded-lg">
                                <p class="text-xs font-bold text-primary mb-1">Verification Status</p>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    All major assets have been cross-referenced with institutional records as of the last reporting period.
                                </p>
                            </div>

                            <div class="p-3 bg-white border border-outline-variant/30 rounded-lg">
                                <p class="text-xs font-bold text-primary mb-1">Risk Assessment</p>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    Debt-to-asset ratio remains within the healthy threshold for institutional compliance standards.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
</template>
