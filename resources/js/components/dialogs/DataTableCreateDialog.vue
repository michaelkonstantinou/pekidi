<script setup lang="ts">

import {DialogContent, Dialog, DialogTitle, DialogFooter, DialogHeader, DialogTrigger, DialogDescription} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import {Plus, X} from "lucide-vue-next";
import { LoaderPinwheel } from 'lucide-vue-next';
import {useI18n} from "vue-i18n";
import DataTableUpsertDialog from "@/components/dialogs/DataTableUpsertDialog.vue";
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
        <DataTableUpsertDialog :title="title" :description="description">
            <slot />
        </DataTableUpsertDialog>
    </Dialog>
</template>
