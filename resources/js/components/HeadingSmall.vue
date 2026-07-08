<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
</script>

<template>
    <header class="mb-5">
        <h3 class="mb-0.5 text-2xl font-medium">{{ $t(title) }}</h3>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ $t(description) }}
        </p>
    </header>
</template>
