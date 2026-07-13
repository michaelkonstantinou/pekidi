<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogTitle,
} from '@/components/ui/dialog'
import {Button} from "@/components/ui/button";
import {ViewRecordRow} from "@/types";
import {useI18n} from "vue-i18n";
import AppDialogContent from "@/components/app-ui/AppDialogContent.vue";
import {FileText} from "lucide-vue-next";

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
        <AppDialogContent title="view_dialog.title" :icon="FileText" @close="emit('close')">
            <!-- Modal Body Area Canvas -->
            <div class="bg-surface-container-lowest">

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
        </AppDialogContent>
    </Dialog>
</template>
