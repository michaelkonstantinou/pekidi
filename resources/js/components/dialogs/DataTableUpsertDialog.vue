<script setup lang="ts">
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
        <slot />
    </AppDialogContent>
</template>
