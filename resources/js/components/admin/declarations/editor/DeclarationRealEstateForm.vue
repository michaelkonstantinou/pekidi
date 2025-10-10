<script setup lang="ts">
import { useForm } from "vee-validate"
import {FormFieldItem} from "@/dataTypes";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import UpsertForm from "@/components/UpsertForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import {useUpsertForm} from "@/composables/useUpsertForm";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";

const props = defineProps({
    declarationId: {
      required: true,
      type: Number
    },
    owner: {
        required: true,
        type: String
    },
    record: {
        required: false,
        type: DeclarationRealEstate,
        default: null
    }
})
const emit = defineEmits(['reload'])
const service = new DeclarationRealEstateService(props.declarationId, props.owner)

const form = useForm()
const formFields: FormFieldItem[] = [
    new FormFieldItem("location", "labels.location", "text", "placeholders.location"),
    new FormFieldItem("area", "labels.area", "number"),
    new FormFieldItem("real_estate_type", "labels.real_estate_type", "text", "placeholders.real_estate_type"),
    new FormFieldItem("acquisition_type", "labels.acquisition_type", "text", "placeholders.acquisition_type"),
    new FormFieldItem("acquisition_year", "labels.acquisition_year", "number"),
    new FormFieldItem("acquisition_value", "labels.acquisition_value", "number"),
    new FormFieldItem("current_value", "labels.current_value", "number"),
    new FormFieldItem("rights_encumbrances", "labels.rights_encumbrances", 'textarea', "placeholders.rights_encumbrances"),
]

if (props.record instanceof DeclarationRealEstate) {
    form.setValues({
        "location": props.record.location,
        "area": props.record.area,
        "real_estate_type": props.record.realEstateType,
        "acquisition_type": props.record.acquisitionType,
        "acquisition_year": props.record.acquisitionYear,
        "acquisition_value": props.record.acquisitionValue,
        "current_value": props.record.currentValue,
        "rights_encumbrances": props.record.rightsEncumbrances,
    })
}

const { onSubmit, isFormLoading } = useUpsertForm(
    form,
    service,
    props.record,
    () => emit('reload')
)
</script>

<template>
    <UpsertForm :formFields="formFields" @submit="onSubmit" :isLoading="isFormLoading"/>
</template>
