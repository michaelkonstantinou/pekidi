import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {useI18n} from "vue-i18n";
import DeclarationOwnerPositionForm from "@/components/admin/declarations/forms/DeclarationOwnerPositionForm.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationAdditionalAsset from "@/models/declarationAdditionalAsset";

export function useAdditionalAssetColumns(apiService: ApiResourceRepository<any>) {
    const {t} = useI18n()

    const additionalAssetColumns: ColumnDef<DeclarationAdditionalAsset>[] = [
        makeTextColumn<DeclarationAdditionalAsset>("name", t("labels.name")),
        makeTextColumn<DeclarationAdditionalAsset>("assetType", t("labels.asset_type")),
        makeCurrencyColumn<DeclarationAdditionalAsset>("value", t("labels.value")),
        makeDateColumn<DeclarationAdditionalAsset>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationOwnerPositionForm,
            (record) => ({
                record: record,
                service: apiService,
                validationSchema: DeclarationAdditionalAsset.getFormValidationSchema(t),
                formFields: DeclarationAdditionalAsset.getFormFieldItems()
            })
        )
    ]

    return {additionalAssetColumns}
}

