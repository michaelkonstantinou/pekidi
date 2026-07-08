<script setup lang="ts" generic="TData, TValue">
import {ColumnDef, getPaginationRowModel} from '@tanstack/vue-table'
import {
    FlexRender,
    getCoreRowModel,
    useVueTable,
} from '@tanstack/vue-table'

import {Button} from "@/components/ui/button";
import {ChevronDown, ChevronLeft, ChevronRight} from "lucide-vue-next";

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
    title?: string
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
    <!-- Table Layout Header Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 gap-4" :class="{'mb-0': compact === true}">
        <!-- Left side: Title and Page Sizer Box -->
        <div class="flex items-center gap-4">
            <h3 class="text-xl font-bold tracking-tight text-neutral-800 font-sans" v-if="title">
                {{ $t(title) }}
            </h3>

            <div v-if="compact !== true" class="bg-white p-1 rounded-default border border-neutral-200/60 shadow-sm flex items-center justify-between gap-2 px-3 py-1.5">
                <span class="text-md font-medium text-neutral whitespace-nowrap">Show:</span>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <button class="bg-transparent border-none text-md font-medium text-neutral focus:ring-0 focus:outline-none flex items-center gap-1 cursor-pointer">
                            <span>{{ pageSize }} records</span>
                            <ChevronDown class="h-3 w-3 text-neutral-500 shrink-0" />
                        </button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="bg-white border border-neutral-200 shadow-md rounded-default">
                        <DropdownMenuRadioGroup v-model="pageSize">
                            <DropdownMenuRadioItem class="text-md cursor-pointer" :value="5">5 records</DropdownMenuRadioItem>
                            <DropdownMenuRadioItem class="text-md cursor-pointer" :value="10">10 records</DropdownMenuRadioItem>
                            <DropdownMenuRadioItem class="text-md cursor-pointer" :value="20">20 records</DropdownMenuRadioItem>
                        </DropdownMenuRadioGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Right side: Quick Slotted Button Element Groups -->
        <div class="flex items-center space-x-2 self-end sm:self-auto">
            <slot name="buttons" />
        </div>
    </div>

    <!-- Data Table Canvas Frame -->
    <div class="bg-white rounded-default border border-neutral-200/60 shadow-sm overflow-hidden" :class="{'mb-0': compact === true}">
        <div class="w-full overflow-x-auto block">
            <div class="inline-block min-w-full align-middle">
                <Table class="w-full text-left border-collapse table-fixed">
                    <TableHeader>
                        <TableRow
                            v-for="headerGroup in table.getHeaderGroups()"
                            :key="headerGroup.id"
                            class="bg-neutral-50/70 border-b border-neutral-200/60 hover:bg-neutral-50/70"
                        >
                            <TableHead
                                v-for="header in headerGroup.headers"
                                :key="header.id"
                                class="px-5 py-3.5 text-xs font-bold text-neutral-500 uppercase tracking-wider font-sans h-auto truncate whitespace-nowrap max-w-[200px]"
                            >
                                <FlexRender
                                    v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                    :props="header.getContext()"
                                />
                            </TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody class="divide-y divide-neutral-100">
                        <template v-if="table.getRowModel().rows?.length">
                            <TableRow
                                v-for="row in table.getRowModel().rows" :key="row.id"
                                :data-state="row.getIsSelected() ? 'selected' : undefined"
                                class="hover:bg-neutral-50/40 transition-colors group"
                            >
                                <TableCell
                                    v-for="cell in row.getVisibleCells()"
                                    :key="cell.id"
                                    class="px-5 py-4 text-sm text-neutral-800 font-medium align-middle truncate whitespace-nowrap max-w-[200px]"
                                >
                                    <FlexRender
                                        :render="cell.column.columnDef.cell"
                                        :props="cell.getContext()"
                                        @deleteItem="onDeleteItem"
                                        @reload="emit('reload')"
                                    />
                                </TableCell>
                            </TableRow>
                        </template>

                        <template v-else>
                            <TableRow>
                                <TableCell :colspan="columns.length" class="h-40 text-center px-5 py-8">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <span class="text-sm font-semibold text-neutral-700">No records found</span>
                                        <span class="text-xs text-neutral-400 max-w-xs">There are no asset registries matching this window view profile yet.</span>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
        </div>

        <!-- Inline Seamless Pagination Footer Section -->
        <div
            v-if="data.length > pageSize"
            class="px-5 py-3.5 bg-neutral-50/70 border-t border-neutral-200/60 flex items-center justify-between"
        >
            <p class="text-xs text-neutral-500 font-medium">
                Showing {{ table.getRowModel().rows?.length || 0 }} of {{ data.length }} records
            </p>
            <div class="flex gap-1">
                <Button
                    variant="outline"
                    size="sm"
                    class="h-7 text-xs rounded-default border-neutral-200 bg-white hover:bg-neutral-50 text-neutral-600 font-medium"
                    :disabled="!table.getCanPreviousPage()"
                    @click="table.previousPage()"
                >
                    <ChevronLeft class="h-3.5 w-3.5 mr-1 shrink-0" />
                    {{ $t('buttons.previous_page' || 'Previous') }}
                </Button>
                <Button
                    variant="outline"
                    size="sm"
                    class="h-7 text-xs rounded-default border-neutral-200 bg-white hover:bg-neutral-50 text-neutral-600 font-medium"
                    :disabled="!table.getCanNextPage()"
                    @click="table.nextPage()"
                >
                    {{ $t('buttons.next_page' || 'Next') }}
                    <ChevronRight class="h-3.5 w-3.5 ml-1 shrink-0" />
                </Button>
            </div>
        </div>
    </div>
</template>
