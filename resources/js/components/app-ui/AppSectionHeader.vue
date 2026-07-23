<script setup lang="ts">
import type { Component } from 'vue';

withDefaults(
    defineProps<{
        title: string;
        icon?: Component;
        value?: string | number | null;
        variant?: 'primary' | 'destructive' | 'default';
    }>(),
    {
        variant: 'default',
    }
);
</script>

<template>
    <div class="pb-4 border-b border-border/50 flex justify-between items-center mb-6">
        <!-- Title & Icon -->
        <h3
            class="font-sans font-bold text-xl flex items-center gap-3"
            :class="{
                'text-primary': variant === 'primary',
                'text-destructive': variant === 'destructive',
                'text-foreground': variant === 'default',
            }"
        >
            <component
                :is="icon"
                v-if="icon"
                class="h-6 w-6 shrink-0"
                :class="{
                    'text-primary': variant === 'primary',
                    'text-destructive': variant === 'destructive',
                    'text-foreground': variant === 'default',
                }"
            />
            <span>{{ $t(title) }}</span>
        </h3>

        <!-- Optional Value / Metric Slot or Prop -->
        <div v-if="value !== undefined">
            <span
                class="font-sans font-bold text-2xl"
                :class="{
                    'text-destructive': variant === 'destructive',
                    'text-foreground': variant !== 'destructive',
                }"
            >
                {{ value }}
            </span>
        </div>
    </div>
</template>
