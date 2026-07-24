<script setup lang="ts">

import {Card, CardContent, CardHeader, CardTitle} from "@/components/ui/card";
import type {Component} from "vue";

defineProps<{
    title: String,
    icon: Component
}>()
</script>

<template>
    <Card class="flex flex-col h-full bg-card border-neutral-200/80 dark:border-border/50 shadow-ambient rounded-sm">
        <!-- Card Header -->
        <CardHeader class="pb-2">
            <CardTitle class="flex items-center gap-2.5 text-base font-semibold text-foreground tracking-tight">
                <div class="p-2 rounded-default bg-secondary/10 text-secondary">
                    <component :is="icon" class="h-4 w-4 shrink-0" />
                </div>
                <span>{{ $t(title) }}</span>
            </CardTitle>
        </CardHeader>

        <!-- Card Content with Scrollable Area -->
        <CardContent class="flex-1 flex flex-col justify-between pt-2 min-h-0">
            <slot />
        </CardContent>
    </Card>
</template>
