<script setup lang="ts">
import {CreditCard, Download, Printer, Wallet} from 'lucide-vue-next'
import {Button} from '@/components/ui/button'
import Declaration from "@/models/declaration";
import HeadingSmall from "@/components/HeadingSmall.vue";
import {onMounted, Ref, ref} from "vue";
import DeclarationOverviewService from "@/services/declarationOverviewService";
import {DeclarationOverview} from "@/models/declarationOverview";
import {useErrorMessager} from "@/composables/useErrorMessager";
import {getLocaleCurrencyString} from "@/helpers/localeHelpers";
import DebtToAssetRatioBadge from "@/components/app-ui/declarations/DebtToAssetRatioBadge.vue";
import DeclarationNetWorthOverview from "@/components/app-ui/declarations/DeclarationNetWorthOverview.vue";
import AppSectionHeader from "@/components/app-ui/AppSectionHeader.vue";
import AssetDistributionChartCard from "@/components/app-ui/declarations/AssetDistributionChartCard.vue";
import DeclarationEvaluationListItemCard from "@/components/app-ui/declarations/DeclarationEvaluationListItemCard.vue";
import ExportDeclarationDialog from "@/components/dialogs/ExportDeclarationDialog.vue";

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
const showExportDialog = ref(false)
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
</script>

<template>
    <div class="w-full space-y-6">

        <!-- Summary Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2 border-b border-neutral-100">
            <HeadingSmall title="Overview" description="some info"/>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <Button size="xl" @click="showExportDialog = true">
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
                        class="group flex justify-between items-center p-3.5 rounded-xl bg-transparent hover:bg-secondary/10 dark:hover:bg-primary/10 transition-colors duration-200"
                    >
                        <div class="flex items-center gap-4">
                            <!-- Light/Dark Secondary Tint Badge -->
                            <div class="w-10 h-10 rounded-lg bg-secondary/15 dark:bg-secondary/25 text-secondary dark:text-primary flex items-center justify-center transition-colors group-hover:bg-secondary group-hover:text-secondary-foreground dark:group-hover:bg-primary dark:group-hover:text-primary-foreground">
                                <component :is="item.icon" class="h-5 w-5 shrink-0" />
                            </div>

                            <div class="flex flex-col justify-center">
                <span class="text-sm font-semibold text-neutral-800 dark:text-foreground group-hover:text-foreground transition-colors">
                    {{ $t(item.label) }}
                </span>

                                <!-- Units Subtitle -->
                                <span
                                    class="text-xs font-medium text-neutral-500 dark:text-muted-foreground transition-opacity duration-200"
                                >
                    {{ item.units }} {{ item.units === 1 ? 'unit' : 'units' }}
                </span>
                            </div>
                        </div>

                        <span class="text-sm font-bold text-neutral-900 dark:text-foreground">{{ item.amount }}</span>
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
            <DeclarationNetWorthOverview :netWorth="overview?.netWorth" />
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

                    <!-- Right Card -->
                    <DeclarationEvaluationListItemCard :evaluation="overview?.evaluation" />
                </div>
            </div>
        </div>

    </div>

    <ExportDeclarationDialog :isOpen="showExportDialog" :declaration="declaration" @close="showExportDialog = false"/>
</template>
