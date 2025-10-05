<script setup lang="ts">
import {FormContext, useForm} from "vee-validate";
import {useI18n} from "vue-i18n";
import {ref, Ref} from "vue";
import {FormFieldItem} from "@/dataTypes";
import {toast} from "vue-sonner";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useDeclarationStore} from "@/stores/declarationStore";
import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

const declarationStore = useDeclarationStore()
const form: FormContext = useForm({
    "initialValues": {
        name: props.declaration.name,
        full_name: props.declaration.fullName,
        born_at: props.declaration.getBornAtAsInputString(),
        home_address: props.declaration.homeAddress,
        national_id: props.declaration.nationalId
    },
})
const {t} = useI18n()
const emit = defineEmits(['saved'])

const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "Name"),
    new FormFieldItem("full_name", "Full name"),
    new FormFieldItem("born_at", "Date of Birth", "date"),
    new FormFieldItem("home_address", "Home address"),
    new FormFieldItem("national_id", "National ID"),
]

const onSubmit = form.handleSubmit(values => {
    isLoading.value = true
    declarationStore.update(values, props.declaration.id).then((data: Declaration | null) => {
        if (data === null) {
            throw new Error()
        }
        toast.success(t("messages.actions.save_success"))
        form.resetForm({
            values: {
                name: data.name,
                full_name: data.fullName,
                born_at: data.getBornAtAsInputString(),
                home_address: data.homeAddress,
                national_id: data.nationalId
            },
            errors: {}
        })
        emit('saved')
    }).catch(errors => {
        updateFormErrors(form, errors)

        const errorCode = errors.response?.status ?? null;
        if (errorCode !== null && errorCode > 400 && errorCode !== 422) {
            toast.error(t("errors.unexpected"))
        }
    }).finally(() => isLoading.value = false)
})
</script>

<template>
    <HeadingSmall title="Personal Details" description="lorem ipsum"/>
    <form @submit.prevent="onSubmit">
    <div class="grid gap-6">
        <FormField
            v-for="field in formFields"
            v-slot="{ componentField }"
            :key="field.name"
            :name="field.name">
            <FormItem v-auto-animate>
                <FormLabel>{{ $t(field.label) }}</FormLabel>
                <FormControl>
                    <Input :type="field.type" :placeholder="field.placeholder" v-bind="componentField" />
                </FormControl>
                <FormMessage />
            </FormItem>
        </FormField>

    </div>
    <Button type="submit" class="mt-5" :disabled="isLoading">
        {{ $t("buttons.save") }}
    </Button>
    </form>
</template>

<style scoped>

</style>
