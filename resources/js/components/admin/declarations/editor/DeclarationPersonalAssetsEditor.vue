<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {onMounted, ref, Ref} from "vue";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import DeclarationFamilyMembersService from "@/services/declarationFamilyMembersService";
import DataCrudTable from "@/components/DataCrudTable.vue";
import {useFamilyMembersTableColumns} from "@/components/admin/declarations/editor/familyMembersTableColumns";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";
import {useRealEstateTableColumns} from "@/components/admin/declarations/editor/realEstateTableColumns";
import DeclarationRealEstateForm from "@/components/admin/declarations/editor/DeclarationRealEstateForm.vue";

const {realEstateColumns} = useRealEstateTableColumns()
const tableRender = ref(0)

const props = defineProps({
    declaration: {
        type: Declaration,
        required: true
    },
    owner: {
        type: String,
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

const declarationRealEstateService = new DeclarationRealEstateService(props.declaration.id, props.owner)
</script>

<template>
    <HeadingSmall title="declarations.personal_assets" description="declarations.personal_assets_description" />
    <DataCrudTable :columns="realEstateColumns" :apiService="declarationRealEstateService" :key="tableRender">
        <template #createForm>
            <DeclarationRealEstateForm :declarationId="declaration.id" :owner="owner" @reload="reRenderTable" />
        </template>
    </DataCrudTable>
</template>
