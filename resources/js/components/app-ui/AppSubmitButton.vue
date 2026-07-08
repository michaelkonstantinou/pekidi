<script setup lang="ts">

import {Button} from "@/components/ui/button";
import {LoaderPinwheel} from "lucide-vue-next";

defineProps({
    isLoading: {
        type: Boolean,
        required: true,
    },
    label: {
        type: String,
        required: false,
        default: 'buttons.save'
    },
})
</script>

<template>
    <Button type="submit" class="mt-5" size="xl" :disabled="isLoading">
        <LoaderPinwheel v-show="isLoading" class="animate-spin"/>
        {{ $t(label) }}
    </Button>
</template>
