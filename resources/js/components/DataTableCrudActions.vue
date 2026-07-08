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
import ConfirmDialog from "@/components/dialogs/ConfirmDialog.vue";
import {ref} from "vue";

const showConfirmDeleteDialog = ref(false)
const showViewRecordDialog = ref(false)

const props = defineProps({
    primaryKey: {required: true}
})

const emit = defineEmits(['reload', 'deleteItem'])

function deleteItem() {
    showConfirmDeleteDialog.value = false
    emit('deleteItem', props.primaryKey)
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                class="w-8 h-8 p-0 rounded-default text-neutral-500 hover:text-neutral-800 hover:bg-neutral-100 transition-colors duration-150"
            >
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>

        <Dialog>
            <DropdownMenuContent
                align="end"
                class="bg-white border border-neutral-200/80 shadow-md rounded-default min-w-[140px] p-1 font-sans"
            >
                <DropdownMenuLabel class="px-2.5 py-1.5 text-xs font-bold tracking-wide text-neutral-400 uppercase">
                    Actions
                </DropdownMenuLabel>
                <DropdownMenuSeparator class="my-1 bg-neutral-100" />

                <!-- View Option Block -->
                <DropdownMenuItem
                    @click="showViewRecordDialog = true"
                    class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 transition-colors duration-100 outline-none"
                >
                    <Eye class="h-4 w-4 text-neutral-400 shrink-0" />
                    <span>View</span>
                </DropdownMenuItem>

                <!-- Edit Dialog Action Trigger -->
                <DialogTrigger asChild>
                    <DropdownMenuItem
                        class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 transition-colors duration-100 outline-none"
                    >
                        <Pencil class="h-4 w-4 text-neutral-400 shrink-0" />
                        <span>Edit</span>
                    </DropdownMenuItem>
                </DialogTrigger>

                <!-- Delete Destructive Option Block -->
                <DropdownMenuItem
                    @click="showConfirmDeleteDialog = true"
                    class="flex items-center gap-2 px-2.5 py-2 text-sm text-destructive hover:bg-destructive/5 focus:bg-destructive/5 font-medium rounded-sm cursor-pointer transition-colors duration-100 outline-none"
                >
                    <Trash2 class="h-4 w-4 text-destructive/70 shrink-0" />
                    <span>Delete</span>
                </DropdownMenuItem>
            </DropdownMenuContent>

            <!-- Edit Form Dialog Window Context Frame -->
            <DialogContent class="bg-white rounded-default border border-neutral-200 shadow-lg max-w-lg p-6 font-sans">
                <DialogHeader class="mb-4">
                    <DialogTitle class="text-lg font-bold text-neutral-800 tracking-tight">
                        Edit record
                    </DialogTitle>
                </DialogHeader>
                <slot name="editForm" @reload="emit('reload')"/>
            </DialogContent>
        </Dialog>
    </DropdownMenu>

    <slot name="viewRecordDialog" :open="showViewRecordDialog" @close="showViewRecordDialog = false"/>
    <ConfirmDialog :open="showConfirmDeleteDialog" destructive @cancel="showConfirmDeleteDialog = false" @confirm="deleteItem"/>
</template>
