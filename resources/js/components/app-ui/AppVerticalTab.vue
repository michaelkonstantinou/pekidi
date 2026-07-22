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
            'w-full justify-start gap-3 px-4 py-2.5 h-auto font-medium text-sm rounded-default transition-all duration-150 cursor-pointer',
            active
              ? 'bg-primary text-primary-foreground font-semibold shadow-sm hover:bg-primary hover:text-primary-foreground'
              : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-200/50 focus:bg-neutral-200/50'
        ]"
        @click="emit('click')"
    >
        <component
            :is="icon"
            class="h-4 w-4 shrink-0"
            :class="active ? 'text-current' : 'text-neutral-400'"
        />
        <span>{{ $t(label) }}</span>
    </Button>
</template>

<style scoped>

</style>
