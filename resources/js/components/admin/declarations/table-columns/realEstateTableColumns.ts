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
import DeclarationBusinessForm from "@/components/admin/declarations/forms/DeclarationBusinessForm.vue";

export function useRealEstateTableColumns() {
    const {t} = useI18n()

    const realEstateColumns: ColumnDef<DeclarationRealEstate>[] = [
        makeTextColumn<DeclarationRealEstate>("realEstateType", t("labels.real_estate_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionType", t("labels.acquisition_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionYear", t("labels.acquisition_year")),
        makeCurrencyColumn<DeclarationRealEstate>("currentValue", t("labels.current_value")),
        makeActionsColumn(
            DeclarationRealEstateForm,
            (record) => ({
                record: record,
                declarationId: record.declarationId,
                owner: record.owner,
            })
        )
    ]

    return {realEstateColumns}
}

