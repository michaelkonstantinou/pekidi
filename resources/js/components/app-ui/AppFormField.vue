<script setup lang="ts">

import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import AppInput from "@/components/app-ui/AppInput.vue";
import {FormFieldItem} from "@/dataTypes";

defineProps({
    field: {
        required: true,
        type: FormFieldItem
    }
})
</script>

<template>
    <FormField
        v-slot="{ componentField }"
        :key="field.name"
        :name="field.name">
        <FormItem v-auto-animate>
            <FormLabel>
                <span v-if="field.isRequired">{{ $t(field.label) }}*</span>
                <span v-else>{{ $t(field.label) }}</span>
            </FormLabel>
            <FormControl>
                <AppInput :field="field" v-bind="componentField" />
            </FormControl>
            <FormMessage />
        </FormItem>
    </FormField>
</template>
