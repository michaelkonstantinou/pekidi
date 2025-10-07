<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {onMounted, ref, Ref} from "vue";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";
import {tableColumns} from "@/components/admin/declarations/tableColumns";
import DeclarationCreateForm from "@/components/admin/declarations/DeclarationCreateForm.vue";
import DataTableCreateDialog from "@/components/dialogs/DataTableCreateDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import AlertError from "@/components/AlertError.vue";
import {familyMembersTableColumns} from "@/components/admin/declarations/editor/familyMembersTableColumns";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import {useErrorMessager} from "@/composables/useErrorMessager";
import {toast} from "vue-sonner";
import DataCrudTable from "@/components/DataCrudTable.vue";

const tableRender = ref(0)

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    }
})

/**
 * In general it is not efficient to re-render the table. However, we only use it during a new addition, where
 * we want to reset the table to its original state and all open modals
 */
function reRenderTable() {
    tableRender.value += 1;
}

const declarationFamilyMembersService = new DeclarationFamilyMembersService(props.declaration.id)
</script>

<template>
    <HeadingSmall title="declarations.family_details" description="declarations.family_details_description" />
    <DataCrudTable :columns="familyMembersTableColumns" :apiService="declarationFamilyMembersService" :key="tableRender">
        <template #createForm>
            <DeclarationFamilyMemberForm :declarationId="declaration.id" @reload="reRenderTable"></DeclarationFamilyMemberForm>
        </template>
    </DataCrudTable>
</template>
