<script setup lang="ts">
import { computed } from 'vue';
import {
    CheckCircle2,
    AlertTriangle,
    ShieldCheck,
    Sparkles
} from 'lucide-vue-next';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { DeclarationEvaluation } from "@/types";

const props = defineProps<{
    evaluation?: DeclarationEvaluation | null;
}>();

const hasData = computed(() => {
    return (props.evaluation?.strengths?.length ?? 0) > 0 || (props.evaluation?.weaknesses?.length ?? 0) > 0;
});
</script>

<template>
    <Card class="flex flex-col h-full bg-card border-neutral-200/80 dark:border-border/50 shadow-ambient rounded-default">
        <!-- Card Header -->
        <CardHeader class="pb-2">
            <CardTitle class="flex items-center gap-2.5 text-base font-semibold text-foreground tracking-tight">
                <div class="p-2 rounded-default bg-secondary/10 text-secondary">
                    <ShieldCheck class="h-4 w-4 shrink-0" />
                </div>
                <span>{{ $t('titles.strengths_and_weaknesses') }}</span>
            </CardTitle>
        </CardHeader>

        <!-- Card Content with Scrollable Area -->
        <CardContent class="flex-1 flex flex-col justify-between pt-2 min-h-0">
            <!-- Scrollable container bounded to prevent parent overflow -->
            <div v-if="hasData" class="max-h-[380px] overflow-y-auto pr-1 space-y-6 custom-scrollbar">
                <!-- Strengths Section -->
                <div v-if="evaluation?.strengths && evaluation.strengths.length > 0">
                    <div class="sticky top-0 bg-card py-1 z-10 flex items-center gap-2 mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                            <Sparkles class="w-3.5 h-3.5" />
                            {{ $t('titles.strengths') }}
                        </span>
                        <span class="text-xs text-muted-foreground/70 font-mono">
                            ({{ evaluation.strengths.length }})
                        </span>
                    </div>

                    <ul class="space-y-2">
                        <li
                            v-for="(strength, index) in evaluation.strengths"
                            :key="`strength-${index}`"
                            class="flex items-start gap-2.5 text-xs text-foreground p-3 rounded-default bg-emerald-500/5 border border-emerald-500/15"
                        >
                            <CheckCircle2 class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" />
                            <span class="leading-relaxed break-words min-w-0 flex-1">{{ strength }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Weaknesses Section -->
                <div v-if="evaluation?.weaknesses && evaluation.weaknesses.length > 0">
                    <div class="sticky top-0 bg-card py-1 z-10 flex items-center gap-2 mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400 flex items-center gap-1.5">
                            <AlertTriangle class="w-3.5 h-3.5" />
                            {{ $t('titles.weaknesses') }}
                        </span>
                        <span class="text-xs text-muted-foreground/70 font-mono">
                            ({{ evaluation.weaknesses.length }})
                        </span>
                    </div>

                    <ul class="space-y-2">
                        <li
                            v-for="(weakness, index) in evaluation.weaknesses"
                            :key="`weakness-${index}`"
                            class="flex items-start gap-2.5 text-xs text-foreground p-3 rounded-default bg-amber-500/5 border border-amber-500/15"
                        >
                            <AlertTriangle class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" />
                            <span class="leading-relaxed break-words min-w-0 flex-1">{{ weakness }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="flex-1 flex flex-col items-center justify-center text-center py-8 text-muted-foreground text-sm">
                {{ $t('labels.no_evaluation_data') }}
            </div>
        </CardContent>
    </Card>
</template>

<style scoped>
/* Subtle Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.3);
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.5);
}
</style>
