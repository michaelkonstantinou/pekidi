import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationBusiness from "@/models/declarationBusiness";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";

export function useBusinessColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const businessColumns: ColumnDef<DeclarationBusiness>[] = [
        makeTextColumn<DeclarationBusiness>("name", t("labels.name")),
        makeTextColumn<DeclarationBusiness>("businessType", t("labels.business_type")),
        makeTextColumn<DeclarationBusiness>("involvementType", t("labels.involvement_type")),
        makeCurrencyColumn<DeclarationBusiness>("value", t("labels.value")),
        makeDateColumn<DeclarationBusiness>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationBusiness.getFormValidationSchema(t),
                formFields: DeclarationBusiness.getFormFieldItems()
            })
        )
    ]

    return {businessColumns}
}

