<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import {Button} from "@/components/ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"
import {ViewRecordRow} from "@/types";
import {useI18n} from "vue-i18n";

const {t} = useI18n()

defineProps({
    open: {
        type: Boolean,
        required: true
    },
    data: {
        type: Array<ViewRecordRow[]>,
        required: true,
    }
})

const emit = defineEmits(['close'])
</script>

<template>
    <Dialog :open="open">
        <DialogContent @close="emit('close')">
            <DialogHeader>
                <DialogTitle>{{ $t('view_dialog.title') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('view_dialog.description') }}
                </DialogDescription>
            </DialogHeader>

            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>{{ $t('view_dialog.field') }}</TableHead>
                        <TableHead>{{ $t('view_dialog.value') }}</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="row in data" :key="row.label">
                        <TableCell class="font-medium">
                            {{ $t(row.label) }}
                        </TableCell>
                        <TableCell>{{ row.value }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <DialogFooter>
                <Button variant="outline" @click="emit('close')">
                    {{ $t('buttons.close')}}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
