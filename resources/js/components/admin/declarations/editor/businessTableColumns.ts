import {makeActionsColumn, makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {getCurrentInstance, h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import ViewRecordDialog from "@/components/dialogs/ViewRecordDialog.vue";
import {useI18n} from "vue-i18n";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateForm from "@/components/admin/declarations/editor/DeclarationRealEstateForm.vue";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationVehicleForm from "@/components/admin/declarations/editor/DeclarationVehicleForm.vue";
import DeclarationBusiness from "@/models/declarationBusiness";
import DeclarationBusinessForm from "@/components/admin/declarations/editor/DeclarationBusinessForm.vue";

export function useBusinessColumns() {
    const {t} = useI18n()

    const businessColumns: ColumnDef<DeclarationBusiness>[] = [
        makeTextColumn<DeclarationBusiness>("name", t("labels.name")),
        makeTextColumn<DeclarationBusiness>("businessType", t("labels.business_type")),
        makeTextColumn<DeclarationBusiness>("involvementType", t("labels.involvement_type")),
        makeCurrencyColumn<DeclarationBusiness>("value", t("labels.value")),
        makeDateColumn<DeclarationBusiness>("updatedAt", t("labels.updated_at")),
        makeActionsColumn(
            DeclarationBusinessForm,
            (record) => ({
                record: record,
                declarationId: record.declarationId,
                owner: record.owner,
            })
        )
    ]

    return {businessColumns}
}

