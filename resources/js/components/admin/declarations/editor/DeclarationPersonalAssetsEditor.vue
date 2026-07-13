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
import DeclarationInvestment from "@/models/declarationInvestment";
import DeclarationInvestmentService from "@/services/declarationInvestmentService";
import DeclarationDepositService from "@/services/declarationDepositService";
import DeclarationAdditionalAssetService from "@/services/declarationAdditionalAssetService";
import {useInvestmentColumns} from "@/components/admin/declarations/table-columns/investmentTableColumns";
import {useDepositColumns} from "@/components/admin/declarations/table-columns/depositTableColumns";
import DeclarationDeposit from "@/models/declarationDeposit";
import {useAdditionalAssetColumns} from "@/components/admin/declarations/table-columns/additionalAssetTableColumns";
import DeclarationAdditionalAsset from "@/models/declarationAdditionalAsset";
import {HelpContent} from "@/types";

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

const declarationRealEstateService = new DeclarationRealEstateService(props.declaration.id, props.owner)
const declarationVehicleService = new DeclarationVehicleService(props.declaration.id, props.owner)
const declarationBusinessService = new DeclarationBusinessService(props.declaration.id, props.owner)
const declarationInvestmentService = new DeclarationInvestmentService(props.declaration.id, props.owner)
const declarationDepositService = new DeclarationDepositService(props.declaration.id, props.owner)
const declarationAdditionalAssetService = new DeclarationAdditionalAssetService(props.declaration.id, props.owner)

const {realEstateColumns} = useRealEstateTableColumns(declarationRealEstateService)
const {vehicleColumns} = useVehicleColumns(declarationVehicleService)
const {businessColumns} = useBusinessColumns(declarationBusinessService)
const {investmentColumns} = useInvestmentColumns(declarationInvestmentService)
const {depositColumns} = useDepositColumns(declarationDepositService)
const {additionalAssetColumns} = useAdditionalAssetColumns(declarationAdditionalAssetService)

const tableRender = ref(0)

/**
 * In general it is not efficient to re-render the table. However, we only use it during a new addition, where
 * we want to reset the table to its original state and all open modals
 */
function reRenderTable() {
    tableRender.value += 1;
}

const realEstateHelpContent: HelpContent = {main: "help_content.real_estate", tip: "help_content.real_estate_tip"}
</script>

<template>
    <HeadingSmall title="declarations.personal_assets" description="declarations.personal_assets_description" />

    <DataCrudTable title="titles.real_estate"
                   :helpContent="realEstateHelpContent"
                   :columns="realEstateColumns"
                   :apiService="declarationRealEstateService"
                   :key="tableRender">
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

    <div class="mb-20"></div>

    <DataCrudTable title="titles.investments"
                   :columns="investmentColumns"
                   :apiService="declarationInvestmentService"
                   :key="tableRender">
        <template #createForm>
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationInvestment.getFormFieldItems()"
                                          :service="declarationInvestmentService"/>
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.deposits" :columns="depositColumns" :apiService="declarationDepositService" :key="tableRender">
        <template #createForm>
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationDeposit.getFormFieldItems()"
                                          :service="declarationDepositService"/>
        </template>
    </DataCrudTable>

    <div class="mb-20"></div>

    <DataCrudTable title="titles.additional_assets" :columns="additionalAssetColumns" :apiService="declarationAdditionalAssetService" :key="tableRender">
        <template #createForm>
            <DeclarationOwnerPositionForm @reload="reRenderTable"
                                          :formFields="DeclarationAdditionalAsset.getFormFieldItems()"
                                          :service="declarationAdditionalAssetService"/>
        </template>
    </DataCrudTable>
</template>
