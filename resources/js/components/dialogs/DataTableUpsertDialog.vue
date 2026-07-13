<script setup lang="ts">

import {DialogContent, DialogDescription, DialogTitle} from "@/components/ui/dialog";
import AppDialogContent from "@/components/app-ui/AppDialogContent.vue";
import type {Component} from "vue";

const props = defineProps<{
    title: {
        type: String,
        required: false,
        default: "labels.add_new",
    },
    icon: {
        type: Component,
        required: false,
        default: null,
    }
}>()

const emit = defineEmits(['close'])

</script>

<template>
    <AppDialogContent @close="emit('close')" :icon="icon" :title="title" :noFooter="true">
        <div class="p-5 max-h-[85vh] overflow-y-scroll">
            <slot />
        </div>

        <template #footer><span></span></template>
    </AppDialogContent>
</template>
