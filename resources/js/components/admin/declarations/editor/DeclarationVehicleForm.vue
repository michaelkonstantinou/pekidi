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
        type: DeclarationVehicle,
        default: null
    }
})
const emit = defineEmits(['reload'])
const service = new DeclarationVehicleService(props.declarationId, props.owner)

const form = useForm()
const formFields: FormFieldItem[] = [
    new FormFieldItem("description", "labels.description", "text", "placeholders.vehicle_description"),
    new FormFieldItem("value", "labels.value", "number"),
]

if (props.record instanceof DeclarationVehicle) {
    form.setValues({
        "value": props.record.value,
        "description": props.record.description,
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
