<script setup lang="ts" generic="TData, TValue">
import {ColumnDef, getPaginationRowModel} from '@tanstack/vue-table'
import {
    FlexRender,
    getCoreRowModel,
    useVueTable,
} from '@tanstack/vue-table'

import {Button} from "@/components/ui/button";
import {ChevronDown} from "lucide-vue-next";

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import {type Ref, ref, watch} from "vue";
import {DropdownMenu, DropdownMenuRadioItem, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuRadioGroup} from "@/components/ui/dropdown-menu";


const props = defineProps<{
    columns: ColumnDef<TData, TValue>[]
    data: TData[],
    compact?: boolean
}>()
const emit = defineEmits(['deleteItem', 'reload'])

const pageSize: Ref<number> = ref<number>(5)

const table = useVueTable({
    get data() { return props.data },
    get columns() { return props.columns },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
})
table.setPageSize(pageSize.value)

watch(pageSize, (newValue) => table.setPageSize(newValue))

function onDeleteItem(primaryKey) {
    emit('deleteItem', primaryKey)
}
</script>

<template>
    <div class="flex items-center justify-between py-4" :class="{'mb-0': compact === true}">
        <!-- Left side -->
        <div class="flex gap-2 items-center">
            <DropdownMenu v-if="compact !== true">
                <DropdownMenuTrigger as-child>
                    <Button variant="outline">
                        Showing {{ pageSize }} rows <ChevronDown class="ml-2 h-4 w-4" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent>
                    <DropdownMenuRadioGroup v-model="pageSize">
                        <DropdownMenuRadioItem :value="5">5</DropdownMenuRadioItem>
                        <DropdownMenuRadioItem :value="10">10</DropdownMenuRadioItem>
                        <DropdownMenuRadioItem :value="20">20</DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>

        <!-- Right side -->
        <div class="flex items-center space-x-2">
            <slot name="buttons" />
        </div>
    </div>

    <div class="border rounded-md" :class="{'mb-0': compact === true}">
        <Table>
            <TableHeader>
                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <TableHead v-for="header in headerGroup.headers" :key="header.id">
                        <FlexRender
                            v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <TableRow
                        v-for="row in table.getRowModel().rows" :key="row.id"
                        :data-state="row.getIsSelected() ? 'selected' : undefined"
                    >
                        <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" @deleteItem="onDeleteItem" @reload="emit('reload')"/>
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            No records to show. Click the button to add new records.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
    <div class="flex items-center justify-end py-4 space-x-2" v-if="data.length > pageSize">
        <Button
            variant="outline"
            size="sm"
            :disabled="!table.getCanPreviousPage()"
            @click="table.previousPage()"
        >
            {{ $t('buttons.previous_page') }}
        </Button>
        <Button
            variant="outline"
            size="sm"
            :disabled="!table.getCanNextPage()"
            @click="table.nextPage()"
        >
            {{ $t('buttons.next_page') }}
        </Button>
    </div>
</template>

<style scoped>

</style>
