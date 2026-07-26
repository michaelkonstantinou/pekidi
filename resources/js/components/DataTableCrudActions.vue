<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Dialog, DialogTrigger} from "@/components/ui/dialog";
import {Pencil, Trash2, Eye} from "lucide-vue-next";
import ConfirmDialog from "@/components/dialogs/ConfirmDialog.vue";
import {ref} from "vue";
import DataTableUpsertDialog from "@/components/dialogs/DataTableUpsertDialog.vue";

const showConfirmDeleteDialog = ref(false)
const showViewRecordDialog = ref(false)
const showEditRecordDialog = ref(false)

const props = defineProps({
    primaryKey: {required: true}
})

const emit = defineEmits(['reload', 'deleteItem'])

function deleteItem() {
    showConfirmDeleteDialog.value = false
    emit('deleteItem', props.primaryKey)
}

function onReload() {
    showEditRecordDialog.value = false
    emit('reload')
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                class="w-8 h-8 p-0 rounded-default text-neutral-500 hover:text-neutral-800 hover:bg-neutral-100 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted/70 transition-colors duration-150"
            >
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>

        <Dialog>
            <DropdownMenuContent
                align="end"
                class="bg-white dark:bg-card border border-neutral-200/80 dark:border-border shadow-md dark:shadow-none rounded-default min-w-[140px] p-1 font-sans inner-glow transition-colors duration-150"
            >
                <DropdownMenuLabel class="px-2.5 py-1.5 text-xs font-bold tracking-wide text-neutral-400 dark:text-muted-foreground uppercase">
                    Actions
                </DropdownMenuLabel>
                <DropdownMenuSeparator class="my-1 bg-neutral-100 dark:bg-border" />

                <!-- View Option Block -->
                <DropdownMenuItem
                    @click="showViewRecordDialog = true"
                    class="group flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 hover:text-neutral-900 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted/70 dark:focus:bg-muted/70 transition-colors duration-100 outline-none"
                >
                    <Eye class="h-4 w-4 text-neutral-400 group-hover:text-neutral-600 dark:text-muted-foreground dark:group-hover:text-foreground shrink-0 transition-colors" />
                    <span>View</span>
                </DropdownMenuItem>

                <!-- Edit Dialog Action Trigger -->
                <DialogTrigger asChild>
                    <DropdownMenuItem
                        @click="showEditRecordDialog = true"
                        class="group flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 hover:text-neutral-900 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted/70 dark:focus:bg-muted/70 transition-colors duration-100 outline-none"
                    >
                        <Pencil class="h-4 w-4 text-neutral-400 group-hover:text-neutral-600 dark:text-muted-foreground dark:group-hover:text-foreground shrink-0 transition-colors" />
                        <span>{{ $t('actions.edit') }}</span>
                    </DropdownMenuItem>
                </DialogTrigger>

                <!-- Delete Destructive Option Block -->
                <DropdownMenuItem
                    @click="showConfirmDeleteDialog = true"
                    class="group flex items-center gap-2 px-2.5 py-2 text-sm text-destructive hover:text-destructive focus:text-destructive hover:bg-destructive/10 focus:bg-destructive/10 dark:text-destructive dark:hover:text-destructive dark:focus:text-destructive dark:hover:bg-destructive/15 dark:focus:bg-destructive/15 font-medium rounded-sm cursor-pointer transition-colors duration-100 outline-none"
                >
                    <Trash2 class="h-4 w-4 text-destructive group-hover:text-destructive shrink-0 transition-colors" />
                    <span>{{ $t('actions.delete') }}</span>
                </DropdownMenuItem>
            </DropdownMenuContent>

            <!-- Edit Form Dialog Window Context Frame -->
            <Dialog :open="showEditRecordDialog">
                <DataTableUpsertDialog :icon="Pencil" buttonLabel="buttons.save" title="titles.edit_record" @close="showEditRecordDialog = false">
                    <slot name="editForm" @reload="onReload"/>
                </DataTableUpsertDialog>
            </Dialog>
        </Dialog>
    </DropdownMenu>

    <slot name="viewRecordDialog" :open="showViewRecordDialog" @close="showViewRecordDialog = false"/>
    <ConfirmDialog :open="showConfirmDeleteDialog" destructive @cancel="showConfirmDeleteDialog = false" @confirm="deleteItem"/>
</template>
