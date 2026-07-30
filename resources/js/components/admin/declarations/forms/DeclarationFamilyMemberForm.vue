<script setup lang="ts">
import { useForm } from "vee-validate"
import {FormFieldItem} from "@/dataTypes";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import UpsertForm from "@/components/UpsertForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import {useUpsertForm} from "@/composables/useUpsertForm";

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
const emit = defineEmits(['reload'])
const declarationFamilyMembersService = new DeclarationFamilyMembersService(props.declarationId)

const form = useForm()
const formFields: FormFieldItem[] = [
    new FormFieldItem("full_name", "labels.full_name", "text", "", [], {}, true),
    new FormFieldItem("born_at", "labels.born_at", "date", "", [], {}, true),
    new FormFieldItem("national_id", "labels.national_id", "text", "", [], {}, true),
    new FormFieldItem("profession", "labels.profession", "text", "", [], {}, true),
    new FormFieldItem(
        "relationship",
        "labels.relationship",
        "select",
        "",
        [
            { label: "labels.spouse", value: "spouse" },
            { label: "labels.child", value: "child" }
        ],
        {},
        true
    ),
];

if (props.record instanceof DeclarationFamilyMember) {
    form.setValues({
        "full_name": props.record.fullName,
        "born_at": props.record.getBornAtAsInputString(),
        "national_id": props.record.nationalId,
        "profession": props.record.profession,
        "relationship": props.record.relationship
    })
}

const { onSubmit, isFormLoading } = useUpsertForm(
    form,
    declarationFamilyMembersService,
    props.record,
    () => emit('reload')
)
</script>

<template>
    <UpsertForm :formFields="formFields" @submit="onSubmit" :isLoading="isFormLoading"/>
</template>
