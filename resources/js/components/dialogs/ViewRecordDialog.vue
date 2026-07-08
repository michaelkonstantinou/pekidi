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
import {X} from "lucide-vue-next";

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
        <!-- Professional Modal Container Box Wrapper -->
        <DialogContent
            @close="emit('close')"
            class="bg-white w-full max-w-2xl rounded-sm border-0 shadow-xl overflow-hidden p-0 gap-0 transition-all duration-200"
        >
        <!-- Modal Header -->
        <div class="bg-primary px-6 py-4 flex justify-between items-center border-t border-primary">
            <div class="flex items-center space-x-3">
                <DialogTitle class="text-base font-bold font-sans tracking-tight text-white/90">
                    {{ $t('view_dialog.title') }}
                </DialogTitle>
            </div>
        </div>

            <!-- Modal Body Area Canvas -->
            <div class="p-6 space-y-8 bg-surface-container-lowest max-h-[70vh] overflow-y-auto">

                <!-- Standard Fields View: Dynamic Data Block mapped to 1 Clean Column -->
                <div>
                    <h3 class="text-xs font-bold text-secondary uppercase tracking-widest mb-4 border-b border-outline-variant pb-2">
                        {{ $t('view_dialog.section_data') }}
                    </h3>

                    <!-- FORCE SINGLE COLUMN TRACK FOR ROWS -->
                    <div class="space-y-4">
                        <div
                            v-for="row in data.filter(r => !r.isLongText && !r.isMeta)"
                            :key="row.label"
                            class="flex flex-col border-b border-neutral-100 pb-3 last:border-0 last:pb-0"
                        >
                            <p class="text-xs text-on-surface-variant font-medium mb-1 font-sans">
                                {{ $t(row.label) }}
                            </p>
                            <p class="text-sm font-semibold text-on-surface font-sans break-words">
                                {{ row.value || '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Long Text Blocks: Isolated Section -->
                <div v-if="data.some(r => r.isLongText)" class="space-y-6">
                    <template v-for="row in data" :key="row.label">
                        <div v-if="row.isLongText">
                            <h3 class="text-xs font-bold text-secondary uppercase tracking-widest mb-3 border-b border-outline-variant pb-2">
                                {{ $t(row.label) }}
                            </h3>
                            <p class="text-sm text-on-surface font-medium font-sans leading-relaxed whitespace-pre-line">
                                {{ row.value || '—' }}
                            </p>
                        </div>
                    </template>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-secondary uppercase tracking-widest mb-4 border-b border-outline-variant pb-2">
                        {{ $t('view_dialog.section_meta') }}
                    </h3>

                    <!-- FORCE SINGLE COLUMN TRACK FOR ROWS -->
                    <div class="space-y-4">
                        <div
                            v-for="row in data.filter(r => r.isMeta)"
                            :key="row.label"
                            class="flex flex-col border-b border-neutral-100 pb-3 last:border-0 last:pb-0"
                        >
                            <p class="text-xs text-on-surface-variant font-medium mb-1 font-sans">
                                {{ $t(row.label) }}
                            </p>
                            <p class="text-sm font-semibold text-on-surface font-sans break-words">
                                {{ row.value || '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-white border-t border-outline-variant px-6 py-4 flex justify-end">
                <Button
                    type="button"
                    class="bg-primary text-white px-8 h-10 rounded-lg font-medium text-sm hover:bg-primary-container transition-all shadow-md active:scale-95 cursor-pointer"
                    @click="emit('close')"
                >
                    {{ $t('buttons.close') }}
                </Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
