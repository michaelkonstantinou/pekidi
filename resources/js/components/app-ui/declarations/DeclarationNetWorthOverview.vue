<script setup lang="ts">
import {User, Users, Home, TrendingUp} from 'lucide-vue-next';
import {DeclarationNetWorth} from "@/types";
import {getLocaleCurrencyString} from "@/helpers/localeHelpers";
import AppSectionHeader from "@/components/app-ui/AppSectionHeader.vue";

defineProps<{
    netWorth?: DeclarationNetWorth | null;
}>();
</script>

<template>
    <AppSectionHeader
        title="titles.net_worth_analysis"
        :icon="TrendingUp"
        variant="primary"
    />

    <!-- 3-Column Net Worth Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Personal Net Worth Card -->
        <div
            class="p-5 bg-card/60 hover:bg-card border border-neutral-200/80 dark:border-border/50 rounded-default shadow-ambient transition-all duration-200 group"
        >
            <div class="flex items-center gap-2.5 mb-3">
                <div class="p-2 rounded-default bg-secondary/10 border border-secondary/20 text-secondary transition-colors group-hover:bg-secondary/15">
                    <User class="h-4 w-4 shrink-0" />
                </div>
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider font-sans">
                    {{ $t('labels.personal_net_worth') }}
                </h3>
            </div>

            <p class="text-2xl font-bold font-mono text-foreground tracking-tight mb-2">
                {{ getLocaleCurrencyString(netWorth?.personal ?? 0) }}
            </p>

            <p class="text-xs text-muted-foreground leading-relaxed">
                {{ $t('descriptions.personal_net_worth_desc') }}
            </p>
        </div>

        <!-- Joint Net Worth Card -->
        <div
            class="p-5 bg-card/60 hover:bg-card border border-neutral-200/80 dark:border-border/50 rounded-default shadow-ambient transition-all duration-200 group"
        >
            <div class="flex items-center gap-2.5 mb-3">
                <div class="p-2 rounded-default bg-secondary/10 border border-secondary/20 text-secondary transition-colors group-hover:bg-secondary/15">
                    <Users class="h-4 w-4 shrink-0" />
                </div>
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider font-sans">
                    {{ $t('labels.joint_net_worth') }}
                </h3>
            </div>

            <p class="text-2xl font-bold font-mono text-foreground tracking-tight mb-2">
                {{ getLocaleCurrencyString(netWorth?.joint ?? 0) }}
            </p>

            <p class="text-xs text-muted-foreground leading-relaxed">
                {{ $t('descriptions.joint_net_worth_desc') }}
            </p>
        </div>

        <!-- Family Net Worth Card -->
        <div
            class="p-5 bg-card/60 hover:bg-card border border-neutral-200/80 dark:border-border/50 rounded-default shadow-ambient transition-all duration-200 group"
        >
            <div class="flex items-center gap-2.5 mb-3">
                <div class="p-2 rounded-default bg-secondary/10 border border-secondary/20 text-secondary transition-colors group-hover:bg-secondary/15">
                    <Home class="h-4 w-4 shrink-0" />
                </div>
                <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider font-sans">
                    {{ $t('labels.family_net_worth') }}
                </h3>
            </div>

            <p class="text-2xl font-bold font-mono text-foreground tracking-tight mb-2">
                {{ getLocaleCurrencyString(netWorth?.family ?? 0) }}
            </p>

            <p class="text-xs text-muted-foreground leading-relaxed">
                {{ $t('descriptions.family_net_worth_desc') }}
            </p>
        </div>
    </div>
</template>
