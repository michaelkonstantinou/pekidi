<script setup lang="ts">
import { useForm } from "vee-validate"
import {FormFieldItem} from "@/dataTypes";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import UpsertForm from "@/components/UpsertForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import {useUpsertForm} from "@/composables/useUpsertForm";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";
import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import ApiResourceRepository from "@/services/apiResourceRepository";

const props = defineProps({
    service: ApiResourceRepository,
    validationSchema: {
        type: Object,
        required: false,
        default: undefined
    },
    record: {
        required: false,
        type: AbstractDeclarationOwnerPosition,
        default: null
    },
    formFields: {
        required: true,
        type: Array<FormFieldItem>
    }
})
const emit = defineEmits(['reload'])

const form = useForm({
    validationSchema: props.validationSchema
})

if (props.record instanceof AbstractDeclarationOwnerPosition) {
    form.setValues(props.record.toFormValues())
}

const { onSubmit, isFormLoading } = useUpsertForm(
    form,
    props.service,
    props.record,
    () => emit('reload')
)
</script>

<template>
    <UpsertForm :validationSchema="validationSchema" :formFields="formFields" @submit="onSubmit" :isLoading="isFormLoading"/>
</template>
