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
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem @click="navigateToEditor"><Pencil />Edit</DropdownMenuItem>
            <DropdownMenuItem><Trash2 /> Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
