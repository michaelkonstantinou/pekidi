<script setup lang="ts">

import {Alert, AlertDescription, AlertTitle} from "@/components/ui/alert";
import {AlertCircle} from "lucide-vue-next";

const props = defineProps({
    errors: {
        type: Array<String>,
        required: false,
        default: []
    }
})
</script>

<template>
    <Alert variant="destructive" v-show="errors.length > 0">
        <AlertCircle class="w-4 h-4" />
        <AlertTitle>ERROR!</AlertTitle>
        <AlertDescription>
            Oops! Something went wrong as we had some errors popping up :(
            <ul class="list-disc">
                <li>Error #1</li>
            </ul>
        </AlertDescription>
    </Alert>
</template>

<style scoped>

</style>
