<script setup lang="ts">
import { computed } from "vue";
import {
    CheckCircle2,
    Scale,
    AlertTriangle,
    AlertOctagon,
    Info
} from "lucide-vue-next";
import {
    calculateDebtToAssetsRatioForOverview,
    getDebtToAssetsRiskLevel,
} from "@/helpers/financeHelpers";
import {DeclarationOverview} from "@/models/declarationOverview";
import {FinancialRiskLevel} from "@/types";

const props = defineProps<{
    overview?: DeclarationOverview | null;
}>();

// Compute ratio percentage (e.g. 42.50)
const ratio = computed(() => calculateDebtToAssetsRatioForOverview(props.overview));

// Compute risk category ("low" | "balanced" | "high" | "insolvent")
const riskLevel = computed(() => getDebtToAssetsRiskLevel(ratio.value));

// Config object mapping risk levels to visual accents and translation keys
const riskConfig = computed(() => {
    const level = riskLevel.value;

    const configs: Record<FinancialRiskLevel, {
        labelKey: string;
        descriptionKey: string;
        badgeClass: string;
        headerClass: string;
        iconClass: string;
        icon: any;
    }> = {
        low: {
            labelKey: "risk.low",
            descriptionKey: "risk.low_tooltip",
            badgeClass: "bg-emerald-50 text-emerald-700 border-emerald-200/60 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800/60",
            headerClass: "bg-emerald-50/80 text-emerald-800 border-emerald-200/60 dark:bg-emerald-950/60 dark:text-emerald-200 dark:border-emerald-800/60",
            iconClass: "text-emerald-600 dark:text-emerald-400",
            icon: CheckCircle2,
        },
        balanced: {
            labelKey: "risk.balanced",
            descriptionKey: "risk.balanced_tooltip",
            badgeClass: "bg-amber-50 text-amber-700 border-amber-200/60 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800/60",
            headerClass: "bg-amber-50/80 text-amber-800 border-amber-200/60 dark:bg-amber-950/60 dark:text-amber-200 dark:border-amber-800/60",
            iconClass: "text-amber-600 dark:text-amber-400",
            icon: Scale,
        },
        high: {
            labelKey: "risk.high",
            descriptionKey: "risk.high_tooltip",
            badgeClass: "bg-orange-50 text-orange-700 border-orange-200/60 dark:bg-orange-950/50 dark:text-orange-300 dark:border-orange-800/60",
            headerClass: "bg-orange-50/80 text-orange-800 border-orange-200/60 dark:bg-orange-950/60 dark:text-orange-200 dark:border-orange-800/60",
            iconClass: "text-orange-600 dark:text-orange-400",
            icon: AlertTriangle,
        },
        insolvent: {
            labelKey: "risk.insolvent",
            descriptionKey: "risk.insolvent_tooltip",
            badgeClass: "bg-rose-50 text-rose-700 border-rose-200/60 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800/60",
            headerClass: "bg-rose-50/80 text-rose-800 border-rose-200/60 dark:bg-rose-950/60 dark:text-rose-200 dark:border-rose-800/60",
            iconClass: "text-rose-600 dark:text-rose-400",
            icon: AlertOctagon,
        },
    };

    return configs[level];
});
</script>

<template>
    <div class="mt-6 pt-4 flex items-center justify-end">
        <!-- Main Pill Container -->
        <div
            class="inline-flex items-center gap-3 px-3 py-1.5 rounded-default bg-card border border-neutral-200 dark:border-border text-foreground shadow-ambient transition-all duration-150"
        >
            <!-- Metric Label & Info Trigger -->
            <div class="flex items-center gap-1.5 text-xs font-sans font-medium text-neutral-500 dark:text-muted-foreground">
                <span>{{ $t('labels.debt_to_asset_ratio') }}</span>

                <!-- Tooltip Container -->
                <div class="relative group/tooltip flex items-center">
                    <button
                        type="button"
                        class="text-neutral-400 dark:text-muted-foreground/70 hover:text-neutral-600 dark:hover:text-foreground transition-colors focus:outline-none"
                        aria-label="Ratio Information"
                    >
                        <Info class="h-3.5 w-3.5" />
                    </button>

                    <!-- Floating Box -->
                    <div
                        class="absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-64 bg-card border border-neutral-200 dark:border-border text-foreground shadow-ambient rounded-default p-2.5 z-50 pointer-events-none"
                    >
                        <!-- Dynamic Top Header Box -->
                        <div
                            class="flex items-center gap-2 px-2.5 py-1.5 rounded-default border mb-2 transition-colors"
                            :class="riskConfig.headerClass"
                        >
                            <component :is="riskConfig.icon" class="h-4 w-4 shrink-0" :class="riskConfig.iconClass" />
                            <span class="font-sans font-semibold text-xs">
                                {{ $t(riskConfig.labelKey) }} ({{ ratio }}%)
                            </span>
                        </div>

                        <!-- Tooltip Body Text -->
                        <p class="px-1 text-xs text-muted-foreground leading-relaxed">
                            {{ $t(riskConfig.descriptionKey) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider line -->
            <div class="h-3.5 w-px bg-neutral-200/80 dark:bg-border"></div>

            <!-- Ratio Value & Dynamic Risk Badge -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold font-mono text-neutral-800 dark:text-foreground">
                    {{ ratio }}%
                </span>

                <!-- Risk Badge -->
                <div
                    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-default border text-xs font-medium transition-colors"
                    :class="riskConfig.badgeClass"
                >
                    <component :is="riskConfig.icon" class="h-3.5 w-3.5 shrink-0" :class="riskConfig.iconClass" />
                    <span>{{ $t(riskConfig.labelKey) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
