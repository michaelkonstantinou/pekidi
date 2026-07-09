<script setup lang="ts">
import { useForm } from "vee-validate"
import {FormFieldItem} from "@/dataTypes";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import UpsertForm from "@/components/UpsertForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import {useUpsertForm} from "@/composables/useUpsertForm";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";
import DeclarationVehicleService from "@/services/declarationVehicleService";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationBusinessService from "@/services/declarationBusinessService";
import DeclarationBusiness from "@/models/declarationBusiness";

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
        type: DeclarationBusiness,
        default: null
    }
})
const emit = defineEmits(['reload'])
const service = new DeclarationBusinessService(props.declarationId, props.owner)

const form = useForm()
const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "labels.name", "text", "placeholders.business_name"),
    new FormFieldItem("business_type", "labels.business_type", "text", "placeholders.business_type"),
    new FormFieldItem("involvement_type", "labels.involvement_type", "text", "placeholders.involvement_type"),
    new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
]

if (props.record instanceof DeclarationBusiness) {
    form.setValues({
        "name": props.record.name,
        "business_type": props.record.businessType,
        "involvement_type": props.record.involvementType,
        "value": props.record.value,
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
