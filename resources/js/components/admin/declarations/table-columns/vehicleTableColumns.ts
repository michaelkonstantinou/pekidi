import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";

export function useVehicleColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const vehicleColumns: ColumnDef<DeclarationVehicle>[] = [
        makeTextColumn<DeclarationVehicle>("description", t("labels.description")),
        makeCurrencyColumn<DeclarationVehicle>("value", t("labels.value")),
        makeDateColumn<DeclarationVehicle>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationVehicle.getFormValidationSchema(t),
                formFields: DeclarationVehicle.getFormFieldItems()
            })
        )
    ]

    return {vehicleColumns}
}

