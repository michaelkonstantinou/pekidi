<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import {
    DialogClose,
    Dialog,
    DialogContent,
    DialogFooter,
    DialogTitle,
    DialogTrigger,
    DialogDescription,
    DialogHeader} from "@/components/ui/dialog";
import {Pencil, Trash2, Eye} from "lucide-vue-next";
import ConfirmDialog from "@/components/ConfirmDialog.vue";
import {ref} from "vue";

const showConfirmDeleteDialog = ref(false)
const props = defineProps({
    primaryKey: {required: true}
})

const emit = defineEmits(['reload'])

function editItem() {
    emit('reload')
}

function deleteItem() {
    showConfirmDeleteDialog.value = true
}


</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <Dialog>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem><Eye />View</DropdownMenuItem>
                <DialogTrigger asChild>
                    <DropdownMenuItem><Pencil />Edit</DropdownMenuItem>
                </DialogTrigger>
                <DropdownMenuItem @click="showConfirmDeleteDialog=true"><Trash2 />Delete</DropdownMenuItem>
            </DropdownMenuContent>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit record</DialogTitle>
                </DialogHeader>
                <slot name="editForm" />
            </DialogContent>
        </Dialog>
    </DropdownMenu>

    <ConfirmDialog :open="showConfirmDeleteDialog" destructive @cancel="showConfirmDeleteDialog=false" @confirm="deleteItem"/>
</template>
