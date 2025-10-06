<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {onMounted, ref, Ref} from "vue";
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
import {useErrorMessager} from "@/composables/useErrorMessager";
import {toast} from "vue-sonner";

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

const {t} = useI18n()
const {toastApiErrors} = useErrorMessager()
const emit = defineEmits(['saved'])

const isLoading: Ref<boolean> = ref(false)
const declarationFamilyMembersService = new DeclarationFamilyMembersService(props.declaration.id)
const rows = ref<DeclarationFamilyMember[]>([]);
const errors = ref<String[]>([])

onMounted(async() => {
    await loadData()
})

async function loadData() {
    isLoading.value = true;
    const data = await declarationFamilyMembersService.all()
    if (data === null) {
        errors.value.push(t("errors.could_not_load_data"))
    } else {
        rows.value = data
    }
    isLoading.value = false;
}

function onDeleteItem(primaryKey: number) {
    isLoading.value = true
    declarationFamilyMembersService.deleteById(primaryKey).then(async () => {
        toast.success(t("actions.delete_successful"));
        await loadData()
    }).catch(err => toastApiErrors(err))
        .finally(() => isLoading.value=false)
}
</script>

<template>
    <HeadingSmall title="declarations.family_details" description="declarations.family_details_description" />
    <AlertError :errors="errors"/>
    <DataTable :data="rows" :columns="familyMembersTableColumns" :compact="true" @reload="loadData" @deleteItem="onDeleteItem">
        <template #buttons>
            <DataTableCreateDialog :isLoading="isLoading">
                <DeclarationFamilyMemberForm :declarationId="declaration.id" @saved="loadData"></DeclarationFamilyMemberForm>
            </DataTableCreateDialog>
        </template>
    </DataTable>
</template>
