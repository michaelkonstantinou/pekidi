<script setup lang="ts">

import {Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue} from "@/components/ui/select";
import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {FormFieldItem} from "@/dataTypes";
import {useI18n} from "vue-i18n";
import {LoaderPinwheel} from "lucide-vue-next";

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
                    <Select v-if="field.type === 'select'" v-bind="componentField">
                        <FormControl class="w-full">
                            <SelectTrigger>
                                <SelectValue :placeholder="field.placeholder" />
                            </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem v-for="option in field.options" :value="option.value">
                                    {{ $t(option.label) }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <FormControl v-if="field.type !== 'select'">
                        <Input :type="field.type" :placeholder="field.placeholder" v-bind="componentField" />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>
        </div>

        <Button type="submit" class="mt-5" :disabled="isLoading">
            <LoaderPinwheel v-show="isLoading" class="animate-spin"/>
            {{ $t("buttons.save") }}
        </Button>
    </form>
</template>
