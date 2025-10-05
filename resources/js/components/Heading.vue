<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
    titleParams?: {
        type: String[],
        required: false,
        default: []
    }
}

defineProps<Props>();
</script>

<template>
    <div class="mb-8 space-y-0.5">
        <h2 class="text-xl font-semibold tracking-tight">{{ $t(title, titleParams) }}</h2>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ $t(description) }}
        </p>
    </div>
</template>
