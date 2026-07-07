<script setup lang="ts">

import {Button} from "@/components/ui/button";
const props = defineProps({
    title: {
        required: true,
        type: String,
    }
})
</script>

<template>
    <Button
        type="submit"
        class="w-full h-12 bg-primary text-primary-foreground hover:bg-primary/90 font-medium transition-transform active:scale-[0.99] flex items-center justify-center gap-2 mt-4 rounded-default shadow-ambient"
    >
        {{ $t(props.title) }}
    </Button>
</template>

<style scoped>

</style>
