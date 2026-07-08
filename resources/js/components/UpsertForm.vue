<script setup lang="ts">

import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {FormFieldItem} from "@/dataTypes";
import {useI18n} from "vue-i18n";
import AppInput from "@/components/app-ui/AppInput.vue";
import AppSelect from "@/components/app-ui/AppSelect.vue";
import AppTextarea from "@/components/app-ui/AppTextarea.vue";
import AppSubmitButton from "@/components/app-ui/AppSubmitButton.vue";

const {t} = useI18n()
const emit = defineEmits(['submit'])
const props = defineProps({
    formFields: {
        type: Array<FormFieldItem>,
        required: true
    },
    isLoading: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <form @submit.prevent="emit('submit')">
        <div class="grid gap-6">
            <FormField
                v-for="field in formFields"
                v-slot="{ componentField }"
                :key="field.name"
                :name="field.name">
                <FormItem v-auto-animate>
                    <FormLabel>{{ $t(field.label) }}</FormLabel>
                    <AppSelect :field="field" v-if="field.type === 'select'" v-bind="componentField" />

                    <FormControl v-if="field.type === 'textarea'">
                        <AppTextarea :field="field" v-bind="componentField" />
                    </FormControl>

                    <FormControl v-if="field.type !== 'select' && field.type !== 'textarea'">
                        <AppInput v-bind="componentField" :field="field"/>
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <AppSubmitButton :isLoading="isLoading"/>
    </form>
</template>
