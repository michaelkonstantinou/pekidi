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
    <Textarea
        :placeholder="$t(field.placeholder)"
        class="min-h-[100px] border-neutral-300 dark:border-border bg-white dark:bg-muted/30 text-neutral-800 dark:text-foreground dark:placeholder:text-muted-foreground rounded-default transition-all duration-150 outline-none focus-visible:outline-none focus:border-primary focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 dark:focus:border-primary dark:focus-visible:border-primary dark:focus-visible:ring-primary/20"
        v-bind="field.attributes ?? {}"
    />
</template>
