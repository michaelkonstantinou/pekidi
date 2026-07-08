<script setup lang="ts">

import {DialogContent, Dialog, DialogTitle, DialogFooter, DialogHeader, DialogTrigger, DialogDescription} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import {Plus, X} from "lucide-vue-next";
import { LoaderPinwheel } from 'lucide-vue-next';
import {useI18n} from "vue-i18n";
const {t} = useI18n()

const props = defineProps({
    buttonLabel: {
        type: String,
        required: false,
        default: "buttons.add_new",
    },
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
    isLoading: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button variant="default" :disabled="isLoading" size="xl">
                <Plus v-show="!isLoading"/>
                <LoaderPinwheel v-show="isLoading" class="animate-spin"/>
                {{ $t(buttonLabel) }}
            </Button>
        </DialogTrigger>
        <DialogContent
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
            <div class="p-5">
                <slot />
            </div>

        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>
