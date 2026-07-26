<script setup lang="ts">
import { ref, watch } from 'vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { FormControl } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { FormFieldItem } from "@/dataTypes";

const props = defineProps({
    field: {
        required: true,
        type: FormFieldItem
    },
    modelValue: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue']);

const isOtherSelected = ref(false);
const customValue = ref('');
const selectedOption = ref('');

// Check if an 'other' option is allowed in this specific field's options array
const hasOtherOption = () => {
    return props.field.options?.some((opt: { value: string }) => opt.value === 'other');
};

const isStandardOption = (val: string) => {
    return props.field.options?.some((opt: { value: string }) => opt.value === val && val !== 'other');
};

// Sync internal state whenever modelValue changes or on initial mount
watch(() => props.modelValue, (newVal) => {
    const valueToParse = newVal ?? '';

    if (isStandardOption(valueToParse)) {
        selectedOption.value = valueToParse;
        isOtherSelected.value = false;
        customValue.value = '';
    } else if (hasOtherOption()) {
        selectedOption.value = 'other';
        isOtherSelected.value = true;
        // If the saved value is literally "other", default customValue to empty string
        customValue.value = valueToParse === 'other' ? '' : valueToParse;
    } else {
        selectedOption.value = valueToParse;
        isOtherSelected.value = false;
        customValue.value = '';
    }
}, { immediate: true });

const handleSelectChange = (val: string) => {
    selectedOption.value = val;

    if (val === 'other') {
        isOtherSelected.value = true;
        emit('update:modelValue', customValue.value);
    } else {
        isOtherSelected.value = false;
        customValue.value = '';
        emit('update:modelValue', val);
    }
};

const handleCustomInput = (e: Event) => {
    const text = (e.target as HTMLInputElement).value;
    customValue.value = text;
    emit('update:modelValue', text);
};
</script>

<template>
    <div class="space-y-3 w-full">
        <Select :model-value="selectedOption" @update:model-value="handleSelectChange">
            <FormControl class="w-full">
                <SelectTrigger size="lg" class="w-full h-11 border-neutral-300 dark:border-border bg-white dark:bg-muted/30 text-neutral-800 dark:text-foreground rounded-default font-sans transition-all duration-150 outline-none focus-visible:outline-none focus:border-primary focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 dark:focus:border-primary dark:focus-visible:border-primary dark:focus-visible:ring-primary/20 text-left">
                    <SelectValue :placeholder="field.placeholder" />
                </SelectTrigger>
            </FormControl>
            <SelectContent class="rounded-default border-neutral-200/80 dark:border-border bg-white dark:bg-card shadow-md dark:shadow-none p-1 font-sans">
                <SelectGroup>
                    <SelectItem
                        v-for="option in field.options"
                        :key="option.value"
                        :value="option.value"
                        class="h-11 px-2.5 hover:bg-neutral-50 focus:bg-neutral-50 dark:hover:bg-muted/70 dark:focus:bg-muted/70 text-neutral-700 dark:text-foreground data-[state=checked]:bg-neutral-100 dark:data-[state=checked]:bg-muted data-[state=checked]:text-neutral-900 dark:data-[state=checked]:text-foreground data-[state=checked]:font-semibold cursor-pointer rounded-sm transition-colors"
                    >
                        {{ $t(option.label) }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>

        <!-- Conditional text field shown ONLY when "Other" is selected -->
        <Input
            v-if="isOtherSelected"
            v-model="customValue"
            @input="handleCustomInput"
            :placeholder="$t('placeholders.please_specify')"
            class="h-11 border-neutral-300 dark:border-border bg-white dark:bg-muted/30 text-neutral-800 dark:text-foreground dark:placeholder:text-muted-foreground rounded-default transition-all duration-150 outline-none focus-visible:outline-none focus:border-primary focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 dark:focus:border-primary dark:focus-visible:border-primary dark:focus-visible:ring-primary/20 font-sans"
        />
    </div>
</template>
