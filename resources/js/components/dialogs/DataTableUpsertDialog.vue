<script setup lang="ts">

import {DialogContent, DialogDescription, DialogTitle} from "@/components/ui/dialog";

const props = defineProps({
    title: {
        type: String,
        required: false,
        default: "labels.add_new",
    },
    description: {
        type: String,
        required: false,
        default: null,
    },
})

const emit = defineEmits(['close'])

</script>

<template>
    <DialogContent @close="emit('close')"
        class="bg-white w-full max-w-2xl rounded-sm border-0 shadow-xl overflow-hidden p-0 gap-0 transition-all duration-200"
    >
        <!-- Modal Header -->
        <div class="bg-primary px-6 py-4 mb-5 flex justify-between items-center border-t border-primary">
            <div class="flex items-center space-x-3">
                <DialogTitle class="text-base font-bold font-sans tracking-tight text-white/90">
                    {{ $t(title) }}
                </DialogTitle>
                <DialogDescription v-if="description !== null">
                    {{ $t(description) }}
                </DialogDescription>
            </div>
        </div>
        <div class="p-5 max-h-[85vh] overflow-y-scroll">
            <slot />
        </div>

    </DialogContent>
</template>
