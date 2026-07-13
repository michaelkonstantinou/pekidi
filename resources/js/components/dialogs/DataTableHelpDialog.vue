<script setup lang="ts">

import {Dialog, DialogTrigger} from "@/components/ui/dialog";
import {Button} from "@/components/ui/button";
import {CircleQuestionMark, Lightbulb} from "lucide-vue-next";
import {useI18n} from "vue-i18n";
const {t} = useI18n()
import type {HelpContent} from "@/types";
import AppDialogContent from "@/components/app-ui/AppDialogContent.vue";
import AppInfoCard from "@/components/app-ui/AppInfoCard.vue";

const props = defineProps<{
    content: HelpContent,
    isOpen: Boolean,
}>()

const emit = defineEmits(['open', 'close'])
</script>

<template>
    <Dialog :open="isOpen">
        <DialogTrigger @click="emit('open')">
            <Button variant="secondary" size="xl">
                <CircleQuestionMark />
                {{ $t("buttons.help") }}
            </Button>
        </DialogTrigger>
        <AppDialogContent title="titles.help_dialog" :icon="CircleQuestionMark" @close="emit('close')">
            <div class="p-5 max-h-[85vh] overflow-y-scroll">
                {{ $t(content.main) }}

                <AppInfoCard v-if="content.tip !== null"
                             class="mt-5 mb-3"
                             title="titles.help_dialog_tip"
                             :content="content.tip"
                             :icon="Lightbulb"/>
            </div>


        </AppDialogContent>
    </Dialog>
</template>
