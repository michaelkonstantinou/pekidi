<script setup lang="ts">

import {DialogContent, Dialog, DialogTitle, DialogFooter, DialogHeader, DialogTrigger, DialogDescription} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";

const props = defineProps({
    buttonLabel: {
        type: String,
        required: false,
        default: "Add new",
    },
    title: {
        type: String,
        required: false,
        default: "Add new",
    },
    description: {
        type: String,
        required: false,
        default: null,
    },
})
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button variant="default">{{ props.buttonLabel }}</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ props.title }}</DialogTitle>
                <DialogDescription v-show="props.description !== null">
                    {{ props.description}}
                </DialogDescription>
            </DialogHeader>

            <slot />
        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>
