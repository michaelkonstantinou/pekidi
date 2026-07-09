import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import DeclarationVehicleService from "@/services/declarationVehicleService";

export function useVehicleColumns() {
    const {t} = useI18n()

    const vehicleColumns: ColumnDef<DeclarationVehicle>[] = [
        makeTextColumn<DeclarationVehicle>("description", t("labels.description")),
        makeCurrencyColumn<DeclarationVehicle>("value", t("labels.value")),
        makeDateColumn<DeclarationVehicle>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: new DeclarationVehicleService(record.declarationId, record.owner),
                formFields: DeclarationVehicle.getFormFieldItems()
            })
        )
    ]

    return {vehicleColumns}
}

