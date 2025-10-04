<script setup lang="ts">

import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import {FormFieldItem} from "@/dataTypes";
import {FormContext, useForm} from "vee-validate";
import {useI18n} from "vue-i18n";
import {ref, Ref} from "vue";
import AuthService from "@/services/authService";
import {toast} from "vue-sonner";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useDeclarationStore} from "@/stores/declarationStore";

const declarationStore = useDeclarationStore()
const form: FormContext = useForm()
const {t} = useI18n()
const emit = defineEmits(['saved'])

const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "Name"),
]

const onSubmit = form.handleSubmit(values => {
    isLoading.value = true
    declarationStore.create(values).then(() => {
        toast.success(t("messages.actions.create_success"))
        form.resetForm()
        emit('saved')
    }).catch(errors => {
        updateFormErrors(form, errors)
    }).finally(() => isLoading.value = false)
})
</script>

<template>
    <form @submit.prevent="onSubmit">
        <div class="grid gap-6">
            <FormField
                v-for="field in formFields"
                v-slot="{ componentField }"
                :key="field.name"
                :name="field.name">
                <FormItem v-auto-animate>
                    <FormLabel>{{ field.label }}</FormLabel>
                    <FormControl>
                        <Input :type="field.type" :placeholder="field.placeholder" v-bind="componentField" />
                    </FormControl>
                    <FormMessage />
                </FormItem>
            </FormField>

        </div>
        <Button type="submit" class="mt-5" :disabled="isLoading">
            {{ $t("buttons.create") }}
        </Button>
    </form>
</template>

