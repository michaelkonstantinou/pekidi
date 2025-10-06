<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import {useI18n} from "vue-i18n";

const {t} = useI18n()

const props = defineProps({
    open: {
        required: true,
        type: Boolean
    },
    destructive: {
        required: false,
        type: Boolean,
        default: false
    },
    labelTitle: {
        required: false,
        default: "confirm_dialog.title",
        type: String
    },
    labelDescription: {
        required: false,
        default: "confirm_dialog.delete_description",
        type: String
    },
    labelYes: {
        required: false,
        default: "buttons.yes_proceed",
        type: String
    },
    labelNo: {
        required: false,
        default: "buttons.cancel",
        type: String
    }
})

const emit = defineEmits(['cancel', 'confirm'])
</script>

<template>
    <AlertDialog :open="open">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ $t(labelTitle) }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ $t(labelDescription) }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="emit('cancel')">{{ $t(labelNo) }}</AlertDialogCancel>
                <AlertDialogAction :class="{'bg-destructive text-white shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60': destructive}"
                                   @click="emit('confirm')">
                    {{ $t(labelYes) }}
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
