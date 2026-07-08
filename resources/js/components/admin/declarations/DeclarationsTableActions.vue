<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import Declaration from "@/models/declaration";
import {Pencil, Trash2} from "lucide-vue-next";
import {useRouter} from "vue-router";

const router = useRouter()

const props = defineProps<{
    record: {
        type: Declaration
    }
}>()

function navigateToEditor() {
    router.push({'name': 'admin.declarations.edit', 'params': {'id': props.record.id}})
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

        <DropdownMenuContent
            align="end"
            class="bg-white border border-neutral-200/80 shadow-md rounded-default min-w-[130px] p-1 font-sans"
        >
            <DropdownMenuItem
                @click="navigateToEditor"
                class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 transition-colors duration-100 outline-none">
                <Pencil />
                Edit
            </DropdownMenuItem>

            <!-- Destructive Delete Item Row -->
            <DropdownMenuItem class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-700 font-medium rounded-sm cursor-pointer hover:bg-neutral-50 focus:bg-neutral-50 transition-colors duration-100 outline-none">
                <Trash2 /> Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
