import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import DeclarationInvestment from "@/models/declarationInvestment";
import ApiResourceRepository from "@/services/apiResourceRepository";

export function useInvestmentColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const investmentColumns: ColumnDef<DeclarationInvestment>[] = [
        makeTextColumn<DeclarationInvestment>("name", t("labels.name")),
        makeTextColumn<DeclarationInvestment>("quantity", t("labels.quantity")),
        makeCurrencyColumn<DeclarationInvestment>("value", t("labels.value")),
        makeDateColumn<DeclarationInvestment>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationInvestment.getFormValidationSchema(t),
                formFields: DeclarationInvestment.getFormFieldItems()
            })
        )
    ]

    return {investmentColumns}
}

