<script setup lang="ts">
import {FormContext, useForm} from "vee-validate";
import {useI18n} from "vue-i18n";
import {onMounted, ref, Ref} from "vue";
import {FormFieldItem} from "@/dataTypes";
import {toast} from "vue-sonner";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useDeclarationStore} from "@/stores/declarationStore";
import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";
import {tableColumns} from "@/components/admin/declarations/tableColumns";
import DeclarationCreateForm from "@/components/admin/declarations/DeclarationCreateForm.vue";
import DataTableCreateDialog from "@/components/DataTableCreateDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import AlertError from "@/components/AlertError.vue";
import {familyMembersTableColumns} from "@/components/admin/declarations/editor/familyMembersTableColumns";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

const {t} = useI18n()
const emit = defineEmits(['saved'])

const isLoading: Ref<boolean> = ref(false)
const declarationFamilyMembersService = new DeclarationFamilyMembersService(props.declaration.id)
const rows = ref<DeclarationFamilyMember[]>([]);
const errors = ref<String[]>([])

onMounted(async() => {
    await loadData()
})

async function loadData() {
    const data = await declarationFamilyMembersService.all()
    if (data === null) {
        errors.value.push(t("errors.could_not_load_data"))
    } else {
        rows.value = data
    }
    isLoading.value = false;
}
</script>

<template>
    <HeadingSmall title="declarations.family_details" description="declarations.family_details_description" />
    <AlertError :errors="errors"/>
    <DataTable :data="rows" :columns="familyMembersTableColumns" :compact="true">
        <template #buttons>
            <DataTableCreateDialog >
                <DeclarationFamilyMemberForm :declarationId="declaration.id" @saved="loadData"></DeclarationFamilyMemberForm>
            </DataTableCreateDialog>
        </template>
    </DataTable>
</template>
