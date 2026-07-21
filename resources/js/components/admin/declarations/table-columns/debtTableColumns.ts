import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationAdditionalAsset from "@/models/declarationAdditionalAsset";
import DeclarationDebt from "@/models/declarationDebt";

export function useDebtColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const debtColumns: ColumnDef<DeclarationDebt>[] = [
        makeTextColumn<DeclarationDebt>("creditorName", t("labels.creditor_name")),
        makeTextColumn<DeclarationDebt>("debtType", t("labels.debt_type")),
        makeCurrencyColumn<DeclarationDebt>("value", t("labels.value")),
        makeDateColumn<DeclarationDebt>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                formFields: DeclarationDebt.getFormFieldItems()
            })
        )
    ]

    return {debtColumns}
}

