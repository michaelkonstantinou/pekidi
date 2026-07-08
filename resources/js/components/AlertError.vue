<script setup lang="ts">

import {Alert, AlertDescription, AlertTitle} from "@/components/ui/alert";
import {AlertCircleIcon} from "lucide-vue-next";

const props = defineProps({
    errors: {
        type: Array<String>,
        required: false,
        default: []
    }
})
</script>

<template>
    <Alert v-if="errors.length > 0" variant="destructive" class="mb-5 border border-neutral-200/80 shadow-sm p-4 rounded-lg">
        <AlertCircleIcon />
        <AlertTitle>
            {{ $t('errors.title') }}
        </AlertTitle>

        <!-- Alert Explanatory Description Canvas Layer -->
        <AlertDescription>
            {{ $t('errors.fetching_data') }}
        </AlertDescription>
    </Alert>
</template>
