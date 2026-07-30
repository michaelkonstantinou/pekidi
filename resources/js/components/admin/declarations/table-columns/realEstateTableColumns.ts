import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";

export function useRealEstateTableColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const realEstateColumns: ColumnDef<DeclarationRealEstate>[] = [
        makeTextColumn<DeclarationRealEstate>("realEstateType", t("labels.real_estate_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionType", t("labels.acquisition_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionYear", t("labels.acquisition_year")),
        makeCurrencyColumn<DeclarationRealEstate>("currentValue", t("labels.current_value")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationRealEstate.getFormValidationSchema(t),
                formFields: DeclarationRealEstate.getFormFieldItems()
            })
        )
    ]

    return {realEstateColumns}
}

