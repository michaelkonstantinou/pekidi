<script setup lang="ts">

import {Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue} from "@/components/ui/select";
import {FormControl} from "@/components/ui/form";
import {FormFieldItem} from "@/dataTypes";

defineProps({
    field: {
        required: true,
        type: FormFieldItem
    }
})
</script>

<template>
    <Select>
        <FormControl class="w-full">
            <SelectTrigger size="lg" class="h-11 border-neutral-300 focus:ring-primary/70 focus:ring-2 focus-visible:ring-primary/70 rounded-default bg-white text-left font-sans">
                <SelectValue :placeholder="field.placeholder" />
            </SelectTrigger>
        </FormControl>
        <SelectContent class="rounded-default border-neutral-300">
            <SelectGroup>
                <SelectItem
                    v-for="option in field.options"
                    :key="option.value"
                    :value="option.value"
                    class="h-11 hover:bg-neutral-50 focus:bg-neutral-50 data-[state=checked]:bg-neutral-200/50 data-[state=checked]:text-neutral-900 data-[state=checked]:font-semibold cursor-pointer"
                >
                    {{ $t(option.label) }}
                </SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>

<style scoped>

</style>
