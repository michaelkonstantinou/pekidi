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
        class="p-5 bg-card hover:bg-card/80 dark:bg-card/80 dark:hover:bg-card border border-neutral-200/80 dark:border-border rounded-default shadow-ambient transition-all duration-200 group"
    >
        <div class="flex items-center gap-2.5 mb-3">
            <!-- Icon Badge -->
            <div class="p-2 rounded-default bg-secondary/15 dark:bg-secondary border border-secondary/20 dark:border-secondary/30 text-secondary dark:text-primary transition-colors group-hover:bg-secondary/20 dark:group-hover:bg-secondary/35">
                <component :is="icon" class="h-4 w-4 shrink-0" />
            </div>

            <!-- Title -->
            <h3 class="text-xs font-semibold text-muted-foreground uppercase tracking-wider font-sans">
                {{ $t(title) }}
            </h3>
        </div>

        <!-- Metric Value -->
        <p class="text-2xl font-bold font-mono text-foreground tracking-tight mb-2">
            {{ getLocaleCurrencyString(value) }}
        </p>

        <!-- Description -->
        <p class="text-xs text-muted-foreground leading-relaxed">
            {{ $t(description) }}
        </p>
    </div>
</template>
