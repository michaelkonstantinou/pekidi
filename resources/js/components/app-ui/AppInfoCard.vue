<script setup lang="ts">

import type {Component} from "vue";

defineProps<{
    icon: Component,
    title: String,
    content: String,
}>()
</script>

<template>
    <div class="flex items-start gap-3 rounded-sm border-l-4 border-primary bg-accent p-4 text-sm">
        <!-- Icon -->
        <component :is="icon" class="h-5 w-5 shrink-0 text-primary fill-primary" />

        <!-- Content -->
        <div class="flex flex-col gap-0.5">
            <span class="font-bold text-foreground">{{ $t(title)}}</span>
            <p class="text-muted-foreground leading-relaxed">
                {{ $t(content) }}
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
