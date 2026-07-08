<script setup lang="ts">

import {Input} from "@/components/ui/input";
import {FormFieldItem} from "@/dataTypes";

defineProps({
    field: {
        required: true,
        type: FormFieldItem
    }
})
</script>

<template>
    <Input :type="field.type"
           :placeholder="field.placeholder"
           class="h-11 border-neutral-300 focus-visible:ring-primary/70 rounded-default"/>
</template>
