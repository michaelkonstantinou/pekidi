<script setup lang="ts">

import {DialogContent, DialogTitle} from "@/components/ui/dialog";
import type {Component} from "vue";
import {Button} from "@/components/ui/button";

const props = defineProps<{
    title: String,
    icon: Component,
    noFooter: {
        type: Boolean,
        required: false,
    }
}>()
const emit = defineEmits(['close'])
</script>

<template>
    <DialogContent
        @close="emit('close')"
        class="bg-white dark:bg-card w-full max-w-2xl rounded-default shadow-xl dark:shadow-2xl overflow-hidden p-0 gap-0 transition-all duration-200"
    >

        <!-- Dialog Header -->
        <div class="bg-primary dark:bg-primary/95 px-6 py-4 mb-5 flex justify-between items-center border-t border-primary dark:border-primary/80">
            <div class="flex items-center space-x-3">
                <div class="flex min-w-0 items-center gap-3">
                    <component
                        :is="icon"
                        class="size-6 shrink-0 text-white dark:text-primary-foreground"
                        :stroke-width="2"
                    />
                    <DialogTitle class="font-sans text-xl font-semibold leading-7 text-white dark:text-primary-foreground">
                        {{ $t(title) }}
                    </DialogTitle>
                </div>
            </div>
        </div>

        <!-- Dialog Body -->
        <div class="p-5 max-h-[85vh] overflow-y-auto text-neutral-800 dark:text-foreground">
            <slot></slot>
        </div>

        <!-- Dialog Footer -->
        <div class="bg-accent/40 dark:bg-muted/50 border-t border-neutral-100 dark:border-border px-6 py-4 flex justify-end" v-if="!noFooter">
            <slot name="footer">
                <Button variant="default" @click="emit('close')" size="xl">
                    {{ $t('buttons.close') }}
                </Button>
            </slot>
        </div>

    </DialogContent>
</template>
