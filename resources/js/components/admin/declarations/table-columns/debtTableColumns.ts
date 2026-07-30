import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationDebt from "@/models/declarationDebt";
import {h} from "vue";

export function useDebtColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const debtColumns: ColumnDef<DeclarationDebt>[] = [
        makeTextColumn<DeclarationDebt>("creditorName", t("labels.creditor_name")),
        {
            accessorKey: "debtType",
            header: () => h("div", {}, t("labels.debt_type")),
            cell: ({ row }) => h(
                "div",
                {},
                t(row.original.getDebtTypeTranslated(), [row.original.debtType])
            ),
        },
        makeCurrencyColumn<DeclarationDebt>("value", t("labels.value")),
        makeDateColumn<DeclarationDebt>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationDebt.getFormValidationSchema(t),
                formFields: DeclarationDebt.getFormFieldItems()
            })
        )
    ]

    return {debtColumns}
}

