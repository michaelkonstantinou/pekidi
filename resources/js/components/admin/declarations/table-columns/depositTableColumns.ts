import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationDeposit from "@/models/declarationDeposit";

export function useDepositColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const depositColumns: ColumnDef<DeclarationDeposit>[] = [
        makeTextColumn<DeclarationDeposit>("name", t("labels.name")),
        makeTextColumn<DeclarationDeposit>("account_number", t("labels.account_number")),
        makeCurrencyColumn<DeclarationDeposit>("value", t("labels.value")),
        makeDateColumn<DeclarationDeposit>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                formFields: DeclarationDeposit.getFormFieldItems()
            })
        )
    ]

    return {depositColumns}
}

