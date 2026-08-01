<script setup lang="ts">
import { ref } from 'vue';
import { FileText, Download, ShieldAlert, FileCheck, UserCheck, Users, Baby } from 'lucide-vue-next';
import AppDialogContent from "@/components/app-ui/AppDialogContent.vue";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Checkbox } from "@/components/ui/checkbox";
import Declaration from "@/models/declaration";
import {Dialog} from "@/components/ui/dialog";
import DeclarationPdfService from "@/services/declarationPdfService";
import {ExportOptions} from "@/types";

const pdfService = new DeclarationPdfService()

const props = defineProps<{
    declaration: Declaration;
    isOpen: Boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const isSubmitting = ref(false);

const options = ref<ExportOptions>({
    documentType: 'official',
    includePersonal: true,
    includeSpouse: props.declaration.hasSpouse,
    includeChildren: props.declaration.hasMinorChildren,
});

const handleDownload = async () => {
    if (isSubmitting.value) return;
    isSubmitting.value = true;

    try {
        await pdfService.download(props.declaration.id, options.value);
    } catch (error) {
        const message = await pdfService.parseBlobError(error);
        alert(message);
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <Dialog :open="isOpen">
    <AppDialogContent
        :icon="FileText"
        title="titles.export_pdf"
        :noFooter="false"
        @close="emit('close')"
    >
        <template #default>
            <div class="space-y-6">

                <!-- Section 1: Document Type -->
                <div class="space-y-3">
                    <h3 class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                        {{ $t('labels.document_type') }}
                    </h3>

                    <RadioGroup v-model="options.documentType" class="space-y-2">
                        <!-- Official Document -->
                        <Label
                            for="doc-official"
                            class="flex items-start gap-3 p-3.5 border rounded-xl cursor-pointer transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-900"
                            :class="options.documentType === 'official' ? 'border-primary bg-primary/5 dark:bg-primary/10' : 'border-neutral-200 dark:border-neutral-800'"
                        >
                            <RadioGroupItem id="doc-official" value="official" class="mt-0.5" />
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5 font-semibold text-sm text-neutral-900 dark:text-neutral-100">
                                    <FileCheck class="w-4 h-4 text-primary" />
                                    <span>{{ $t('labels.official_document') }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-normal">
                                    {{ $t('descriptions.official_document_help') }}
                                </p>
                            </div>
                        </Label>

                        <!-- Official Redacted -->
                        <Label
                            for="doc-redacted"
                            class="flex items-start gap-3 p-3.5 border rounded-xl cursor-pointer transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-900"
                            :class="options.documentType === 'official_redacted' ? 'border-primary bg-primary/5 dark:bg-primary/10' : 'border-neutral-200 dark:border-neutral-800'"
                        >
                            <RadioGroupItem id="doc-redacted" value="official_redacted" class="mt-0.5" />
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5 font-semibold text-sm text-neutral-900 dark:text-neutral-100">
                                    <ShieldAlert class="w-4 h-4 text-amber-500" />
                                    <span>{{ $t('labels.official_document_redacted') }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-normal">
                                    {{ $t('descriptions.official_redacted_help') }}
                                </p>
                            </div>
                        </Label>

                        <!-- Friendly Summary -->
                        <Label
                            for="doc-friendly"
                            class="flex items-start gap-3 p-3.5 border rounded-xl cursor-pointer transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-900"
                            :class="options.documentType === 'friendly' ? 'border-primary bg-primary/5 dark:bg-primary/10' : 'border-neutral-200 dark:border-neutral-800'"
                        >
                            <RadioGroupItem id="doc-friendly" value="friendly" class="mt-0.5" />
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-1.5 font-semibold text-sm text-neutral-900 dark:text-neutral-100">
                                    <FileText class="w-4 h-4 text-secondary" />
                                    <span>{{ $t('labels.friendly_summary') }}</span>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-normal">
                                    {{ $t('descriptions.friendly_summary_help') }}
                                </p>
                            </div>
                        </Label>
                    </RadioGroup>
                </div>

                <!-- Section 2: Included Asset Scope -->
                <div class="space-y-3">
                    <h3 class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                        {{ $t('labels.asset_selection') }}
                    </h3>

                    <div class="space-y-2.5">
                        <div class="flex items-center space-x-3">
                            <Checkbox
                                id="inc-personal"
                                v-model="options.includePersonal"
                            />
                            <Label for="inc-personal" class="flex items-center gap-2 text-sm font-medium cursor-pointer">
                                <UserCheck class="w-4 h-4 text-neutral-500" />
                                <span>{{ $t('labels.include_personal_assets') }}</span>
                            </Label>
                        </div>

                        <div class="flex items-center space-x-3">
                            <Checkbox
                                id="inc-spouse"
                                v-model="options.includeSpouse"
                                :disabled="!declaration.hasSpouse"
                            />
                            <Label
                                for="inc-spouse"
                                class="flex items-center gap-2 text-sm font-medium cursor-pointer"
                                :class="{ 'opacity-50 cursor-not-allowed': !declaration.hasSpouse }"
                            >
                                <Users class="w-4 h-4 text-neutral-500" />
                                <span>{{ $t('labels.include_spouse_assets') }}</span>
                            </Label>
                        </div>

                        <div class="flex items-center space-x-3">
                            <Checkbox
                                id="inc-children"
                                v-model="options.includeChildren"
                                :disabled="!declaration.hasMinorChildren"
                            />
                            <Label
                                for="inc-children"
                                class="flex items-center gap-2 text-sm font-medium cursor-pointer"
                                :class="{ 'opacity-50 cursor-not-allowed': declaration.hasMinorChildren }"
                            >
                                <Baby class="w-4 h-4 text-neutral-500" />
                                <span>{{ $t('labels.include_children_assets') }}</span>
                            </Label>
                        </div>
                    </div>
                </div>

            </div>
        </template>

        <template #footer>
            <div class="flex items-center justify-end gap-2 w-full">
                <Button variant="outline" type="button" @click="emit('close')" size="xl">
                    {{ $t('labels.cancel') }}
                </Button>

                <Button
                    type="button"
                    size="xl"
                    :disabled="isSubmitting"
                    @click="handleDownload"
                >
                    <Download class="w-4 h-4 mr-2" />
                    {{ $t('labels.generate_pdf') }}
                </Button>
            </div>
        </template>
    </AppDialogContent>
    </Dialog>
</template>
