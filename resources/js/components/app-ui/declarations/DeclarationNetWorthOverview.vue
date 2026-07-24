<script setup lang="ts">
import {User, Users, Home, TrendingUp} from 'lucide-vue-next';
import {DeclarationNetWorth} from "@/types";
import AppSectionHeader from "@/components/app-ui/AppSectionHeader.vue";
import DeclarationNetWorthCard from "@/components/app-ui/declarations/DeclarationNetWorthCard.vue";

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
        <DeclarationNetWorthCard
            :icon="User"
            title="labels.personal_net_worth"
            description="descriptions.personal_net_worth_desc"
            :value="netWorth?.personal ?? 0" />

        <!-- Joint Net Worth Card -->
        <DeclarationNetWorthCard
            :icon="Users"
            title="labels.joint_net_worth"
            description="descriptions.joint_net_worth_desc"
            :value="netWorth?.joint ?? 0" />

        <!-- Family Net Worth Card -->
        <DeclarationNetWorthCard
            :icon="Home"
            title="labels.family_net_worth"
            description="descriptions.family_net_worth_desc"
            :value="netWorth?.family ?? 0" />
    </div>
</template>
