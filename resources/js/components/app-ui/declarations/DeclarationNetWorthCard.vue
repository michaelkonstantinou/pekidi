<script setup lang="ts">

import {getLocaleCurrencyString} from "@/helpers/localeHelpers";
import type {Component} from "vue";

defineProps<{
    title: String,
    description: String,
    value: Number,
    icon: Component
}>()
</script>

<template>
    <div
        class="p-5 bg-card/60 hover:bg-card border border-neutral-200/80 dark:border-border/50 rounded-default shadow-ambient transition-all duration-200 group"
    >
        <div class="flex items-center gap-2.5 mb-3">
            <div class="p-2 rounded-default bg-secondary/10 border border-secondary/20 text-secondary transition-colors group-hover:bg-secondary/15">
                <component :is="icon" class="h-4 w-4 shrink-0" />
            </div>
            <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider font-sans">
                {{ $t(title) }}
            </h3>
        </div>

        <p class="text-2xl font-bold font-mono text-foreground tracking-tight mb-2">
            {{ getLocaleCurrencyString(value) }}
        </p>

        <p class="text-xs text-muted-foreground leading-relaxed">
            {{ $t(description) }}
        </p>
    </div>
</template>

<style scoped>

</style>
