<script setup lang="ts">
import {onMounted, ref, Ref} from "vue";
import HeadingSmall from "@/components/HeadingSmall.vue";
import Declaration from "@/models/declaration";
import DataCrudTable from "@/components/DataCrudTable.vue";
import DeclarationRealEstateService from "@/services/declarationRealEstateService";
import {useRealEstateTableColumns} from "@/components/admin/declarations/table-columns/realEstateTableColumns";
import DeclarationVehicleService from "@/services/declarationVehicleService";
import DeclarationBusinessService    from "@/services/declarationBusinessService";
import {useVehicleColumns} from "@/components/admin/declarations/table-columns/vehicleTableColumns";
import {useBusinessColumns} from "@/components/admin/declarations/table-columns/businessTableColumns";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationBusiness from "@/models/declarationBusiness";
import DeclarationRealEstate from "@/models/declarationRealEstate";

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
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationRealEstate.getFormFieldItems()"
                                          :service="declarationRealEstateService"/>
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.vehicles" :columns="vehicleColumns" :apiService="declarationVehicleService" :key="tableRender">
        <template #createForm>
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationVehicle.getFormFieldItems()"
                                          :service="declarationVehicleService"/>
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.businesses" :columns="businessColumns" :apiService="declarationBusinessService" :key="tableRender">
        <template #createForm>
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationBusiness.getFormFieldItems()"
                                          :service="declarationBusinessService"/>
        </template>
    </DataCrudTable>
</template>
