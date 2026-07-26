<script setup lang="ts">
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { PieChart as PieChartIcon } from 'lucide-vue-next';
import { Donut } from "@unovis/ts";
import { VisDonut, VisSingleContainer } from "@unovis/vue";
import {
    ChartContainer,
    ChartTooltip,
    ChartTooltipContent,
    componentToString,
    type ChartConfig,
} from "@/components/ui/chart";
import { DeclarationAssetDistributionChart } from "@/types";
import { getLocaleCurrencyString } from "@/helpers/localeHelpers";
import AppCard from "@/components/app-ui/AppCard.vue";

const { t } = useI18n();

const props = defineProps<{
    chartData?: DeclarationAssetDistributionChart | null;
}>();

// Dynamically resolves to whatever CSS variable is active (light or dark)
const PALETTE_COLORS = [
    'var(--chart-1)',
    'var(--chart-2)',
    'var(--chart-3)',
    'var(--chart-4)',
    'var(--chart-5)',
    'var(--chart-6)',
];

// Map relation keys to colors and translated names
const chartConfig = computed<ChartConfig>(() => ({
    real_estates: { label: `${t("titles.real_estates")}: `, color: PALETTE_COLORS[0] },
    vehicles: { label: `${t("titles.vehicles")}: `, color: PALETTE_COLORS[1] },
    businesses: { label: `${t("titles.businesses")}: `, color: PALETTE_COLORS[2] },
    investments: { label: `${t("titles.investments")}: `, color: PALETTE_COLORS[3] },
    deposits: { label: `${t("titles.deposits")}: `, color: PALETTE_COLORS[4] },
    additional_assets: { label: `${t("titles.additional_assets")}: `, color: PALETTE_COLORS[5] },
}));

// Formatted data array expected by Unovis VisDonut
const formattedChartData = computed(() => {
    if (!props.chartData?.series || props.chartData.series.length === 0) return [];

    return props.chartData.series.map((item, index) => {
        const key = item.relation as keyof typeof chartConfig.value;
        const color = chartConfig.value[key]?.color ?? PALETTE_COLORS[index % PALETTE_COLORS.length];

        return {
            labelKey: item.relation,
            value: item.total_value,
            percentage: item.percentage,
            fill: color,
            color,
            // Assign pre-formatted string to dynamic relation key so ChartTooltipContent renders it directly
            [key]: getLocaleCurrencyString(item.total_value),
        };
    });
});

type ChartDataItem = typeof formattedChartData.value[number];
</script>

<template>
    <AppCard :icon="PieChartIcon" title="titles.asset_distribution">
        <div class="flex-1 flex items-center justify-center min-h-[200px] my-2">
            <template v-if="formattedChartData.length > 0">
                <ChartContainer
                    :config="chartConfig"
                    class="mx-auto aspect-square max-h-[220px] w-full"
                    :style="{
                        '--vis-donut-central-label-font-size': '1rem',
                        '--vis-donut-central-label-font-weight': '700',
                        '--vis-donut-central-label-text-color': 'var(--foreground)',
                        '--vis-donut-central-sub-label-text-color': 'var(--muted-foreground)',
                    }"
                >
                    <VisSingleContainer
                        :data="formattedChartData"
                        :margin="{ top: 10, bottom: 10, left: 10, right: 10 }"
                    >
                        <VisDonut
                            :value="(d: ChartDataItem) => d.value"
                            :color="(d: ChartDataItem) => d.color"
                            :arc-width="28"
                            :central-label-offset-y="5"
                            :central-label="getLocaleCurrencyString(chartData?.total_assets_value ?? 0)"
                            :central-sub-label="$t('titles.total_assets')"
                        />
                        <ChartTooltip
                            :triggers="{
                                [Donut.selectors.segment]: componentToString(chartConfig, ChartTooltipContent, { hideLabel: true })!,
                            }"
                        />
                    </VisSingleContainer>
                </ChartContainer>
            </template>

            <!-- Empty State -->
            <div v-else class="text-center py-8 text-muted-foreground text-sm font-medium">
                {{ $t('labels.no_assets_declared') }}
            </div>
        </div>

        <!-- Custom Legend with Formatted Currency and Percentage -->
        <div v-if="formattedChartData.length > 0" class="pt-4 border-t border-neutral-200/60 dark:border-border space-y-2">
            <div
                v-for="item in formattedChartData"
                :key="item.labelKey"
                class="flex items-center justify-between text-xs group py-0.5"
            >
                <div class="flex items-center gap-2 min-w-0">
                    <span
                        class="w-2.5 h-2.5 rounded-full shrink-0 transition-transform group-hover:scale-125"
                        :style="{ backgroundColor: item.color }"
                    />
                    <span class="font-medium text-neutral-600 dark:text-muted-foreground truncate group-hover:text-foreground transition-colors">
                        {{ $t(`titles.${item.labelKey}`) }}
                    </span>
                </div>

                <div class="flex items-center gap-3 shrink-0 ml-2">
                    <span class="font-mono font-semibold text-neutral-900 dark:text-foreground">
                        {{ getLocaleCurrencyString(item.value) }}
                    </span>
                    <span class="font-mono text-neutral-500 dark:text-muted-foreground w-12 text-right">
                        {{ item.percentage.toFixed(1) }}%
                    </span>
                </div>
            </div>
        </div>
    </AppCard>
</template>
