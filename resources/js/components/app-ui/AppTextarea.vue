<script setup lang="ts">

import {Input} from "@/components/ui/input";
import {FormFieldItem} from "@/dataTypes";
import {Textarea} from "@/components/ui/textarea";

defineProps({
    field: {
        required: true,
        type: FormFieldItem
    }
})
</script>

<template>
    <Textarea :type="field.type"
              :placeholder="$t(field.placeholder)"
              class="border-neutral-300 focus-visible:ring-primary/70 rounded-default"/>
</template>
