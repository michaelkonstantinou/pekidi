<script setup lang="ts">

import {FileText} from "lucide-vue-next";
import {Button} from "@/components/ui/button";
import type {Component} from "vue";

defineProps<{
    label: String,
    active: Boolean,
    icon: Component
}>();

const emit = defineEmits(['click'])
</script>

<template>
    <Button
        variant="ghost"
        :class="[
            'group w-full justify-start gap-3 px-3.5 py-2.5 h-auto font-sans text-sm rounded-default transition-all duration-150 cursor-pointer select-none',
            active
              ? 'bg-primary text-primary-foreground hover:bg-primary hover:text-primary-foreground font-semibold shadow-sm dark:bg-primary dark:text-secondary dark:hover:bg-primary dark:hover:text-secondary dark:shadow-none'
              : 'text-neutral-600 hover:text-primary hover:bg-primary/10 dark:text-muted-foreground dark:hover:text-primary dark:hover:bg-muted/70 font-normal'
        ]"
        @click="emit('click')"
    >
        <component
            :is="icon"
            class="h-4 w-4 shrink-0 transition-colors duration-150"
            :class="[
                active
                  ? 'text-primary-foreground dark:text-secondary'
                  : 'text-neutral-400 group-hover:text-primary dark:text-muted-foreground dark:group-hover:text-primary'
            ]"
        />
        <span class="tracking-wide">{{ $t(label) }}</span>
    </Button>
</template>
