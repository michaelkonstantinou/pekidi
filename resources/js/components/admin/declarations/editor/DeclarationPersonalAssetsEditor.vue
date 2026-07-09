<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {onMounted, ref, Ref} from "vue";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";
import DataCrudTable from "@/components/DataCrudTable.vue";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";
import {useRealEstateTableColumns} from "@/components/admin/declarations/editor/realEstateTableColumns";
import DeclarationRealEstateForm from "@/components/admin/declarations/editor/DeclarationRealEstateForm.vue";
import DeclarationVehicleService from "@/services/declarationVehicleService";
import DeclarationBusinessService    from "@/services/declarationBusinessService";
import {useVehicleColumns} from "@/components/admin/declarations/editor/vehicleTableColumns";
import DeclarationVehicleForm from "@/components/admin/declarations/editor/DeclarationVehicleForm.vue";
import {useBusinessColumns} from "@/components/admin/declarations/editor/businessTableColumns";
import DeclarationBusinessForm from "@/components/admin/declarations/editor/DeclarationBusinessForm.vue";

const {realEstateColumns} = useRealEstateTableColumns()
const {vehicleColumns} = useVehicleColumns()
const {businessColumns} = useBusinessColumns()

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
const declarationVehicleService = new DeclarationVehicleService(props.declaration.id, props.owner)
const declarationBusinessService = new DeclarationBusinessService(props.declaration.id, props.owner)
</script>

<template>
    <HeadingSmall title="declarations.personal_assets" description="declarations.personal_assets_description" />

    <DataCrudTable title="titles.real_estate" :columns="realEstateColumns" :apiService="declarationRealEstateService" :key="tableRender">
        <template #createForm>
            <DeclarationRealEstateForm :declarationId="declaration.id" :owner="owner" @reload="reRenderTable" />
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.vehicles" :columns="vehicleColumns" :apiService="declarationVehicleService" :key="tableRender">
        <template #createForm>
            <DeclarationVehicleForm :declarationId="declaration.id" :owner="owner" @reload="reRenderTable" />
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.businesses" :columns="businessColumns" :apiService="declarationBusinessService" :key="tableRender">
        <template #createForm>
            <DeclarationBusinessForm :declarationId="declaration.id" :owner="owner" @reload="reRenderTable" />
        </template>
    </DataCrudTable>
</template>
