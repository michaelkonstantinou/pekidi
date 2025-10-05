<script setup lang="ts">
import { toTypedSchema } from "@vee-validate/zod"
import { useForm } from "vee-validate"
import {h, onMounted, ref} from "vue"
import {toast} from "vue-sonner";
import {FormFieldItem} from "@/dataTypes";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import UserDeclarationService from "@/services/userDeclarationService";
import Declaration from "@/models/declaration";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useI18n} from "vue-i18n";
import UpsertForm from "@/components/UpsertForm.vue";
import {useErrorMessager} from "@/composables/useErrorMessager";

const {t} = useI18n()
const {toastApiErrors} = useErrorMessager()
const userDeclarationService = new UserDeclarationService()
const isLoading = ref(false)

const props = defineProps({
    declarationId: {
      required: true,
      type: Number
    },
    record: {
        required: false,
        type: DeclarationFamilyMember,
        default: null
    }
})
const emit = defineEmits(['saved'])

const form = useForm()
const formFields: FormFieldItem[] = [
    new FormFieldItem("full_name", "labels.full_name"),
    new FormFieldItem("born_at", "labels.born_at", "date"),
    new FormFieldItem("national_id", "labels.national_id"),
    new FormFieldItem("profession", "labels.profession"),
    new FormFieldItem("relationship", "labels.relationship", "select", "", [
        {label: "labels.spouse", value: "spouse"},
        {label: "labels.child", value: "child"}
    ]),
]

if (props.record !== null) {
    form.setValues({
        "first_name": props.record.firstName,
        "last_name": props.record.lastName,
        "email": props.record.email,
        "telephone": props.record.telephone
    })
}

const onSubmit = form.handleSubmit(values => {
    isLoading.value = true
    userDeclarationService.createFamilyMember(values, props.declarationId).then(() => {
        toast.success(t("messages.actions.save_success"))
        form.resetForm()
        emit('saved')
    }).catch(errors => {
        updateFormErrors(form, errors)
        toastApiErrors(errors)
    }).finally(() => isLoading.value = false)
})
</script>

<template>
    <UpsertForm :formFields="formFields" @submit="onSubmit"/>
</template>
