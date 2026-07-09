import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {getCurrentInstance, h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/forms/DeclarationFamilyMemberForm.vue";
import ViewRecordDialog from "@/components/dialogs/ViewRecordDialog.vue";
import {useI18n} from "vue-i18n";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateForm from "@/components/admin/declarations/forms/DeclarationRealEstateForm.vue";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationVehicleForm from "@/components/admin/declarations/forms/DeclarationVehicleForm.vue";

export function useVehicleColumns() {
    const {t} = useI18n()

    const vehicleColumns: ColumnDef<DeclarationVehicle>[] = [
        makeTextColumn<DeclarationVehicle>("description", t("labels.description")),
        makeCurrencyColumn<DeclarationVehicle>("value", t("labels.value")),
        makeDateColumn<DeclarationVehicle>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationVehicleForm,
            (record) => ({
                record: record,
                declarationId: record.declarationId,
                owner: record.owner,
            })
        )
    ]

    return {vehicleColumns}
}

