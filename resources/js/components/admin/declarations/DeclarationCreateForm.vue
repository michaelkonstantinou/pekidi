<script setup lang="ts">

import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Button} from "@/components/ui/button";
import {FormFieldItem} from "@/dataTypes";
import {FormContext, useForm} from "vee-validate";
import {useI18n} from "vue-i18n";
import {ref, Ref} from "vue";
import {toast} from "vue-sonner";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useDeclarationStore} from "@/stores/declarationStore";
import {LoaderPinwheel} from "lucide-vue-next";
import AppInput from "@/components/app-ui/AppInput.vue";
import AppFormField from "@/components/app-ui/AppFormField.vue";

const declarationStore = useDeclarationStore()
const form: FormContext = useForm()
const {t} = useI18n()
const emit = defineEmits(['saved'])

const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "labels.name", "text", "", [], {}, true),
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
            <AppFormField v-for="field in formFields"
                          :field="field"
                          v-slot="{ componentField }"
                          :key="field.name" />

        </div>
        <Button type="submit" class="mt-5 w-full" size="xl" :disabled="isLoading">
            <LoaderPinwheel v-show="isLoading" class="animate-spin"/>
            {{ $t("buttons.create") }}
        </Button>
    </form>
</template>

