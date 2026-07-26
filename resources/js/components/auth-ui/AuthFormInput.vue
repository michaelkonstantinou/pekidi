<script setup>
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"

defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    id: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    icon: {
        type: [Object, Function],
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    placeholder: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="space-y-1.5 text-left">
        <!-- Label & Optional Header Action -->
        <div class="flex items-center justify-between">
            <Label :for="id" class="text-sm font-medium text-neutral-700 dark:text-foreground">
                {{ label }}
            </Label>
            <slot name="action" />
        </div>

        <!-- Input Block -->
        <div class="relative">
            <component
                :is="icon"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 dark:text-muted-foreground h-4 w-4 pointer-events-none"
            />
            <Input
                :id="id"
                :type="type"
                :placeholder="placeholder"
                :value="modelValue"
                @input="emit('update:modelValue', $event.target.value)"
                required
                class="h-11 pl-9 pr-3 border-neutral-300 dark:border-border dark:bg-muted/30 dark:text-foreground dark:placeholder:text-muted-foreground focus-visible:ring-primary rounded-default"
                v-bind="$attrs"
            />
        </div>
    </div>
</template>
