import {makeCurrencyColumn, makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {getCurrentInstance, h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import ViewRecordDialog from "@/components/dialogs/ViewRecordDialog.vue";
import {useI18n} from "vue-i18n";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationRealEstateForm from "@/components/admin/declarations/editor/DeclarationRealEstateForm.vue";

export function useRealEstateTableColumns() {
    const {t} = useI18n()

    const realEstateColumns: ColumnDef<DeclarationRealEstate>[] = [
        makeTextColumn<DeclarationRealEstate>("realEstateType", t("labels.real_estate_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionType", t("labels.acquisition_type")),
        makeTextColumn<DeclarationRealEstate>("acquisitionYear", t("labels.acquisition_year")),
        makeCurrencyColumn<DeclarationRealEstate>("currentValue", t("labels.current_value")),
        {
            id: 'actions',
            enableHiding: false,
            cell: ({ row }) => {
                const record = row.original
                const instance = getCurrentInstance()
                return h(DataTableCrudActions, {
                    primaryKey: record.id,
                    onDeleteItem: (payload: any) => instance?.proxy?.$emit('deleteItem', payload),
                    onReload: (payload: any) => instance?.proxy?.$emit('reload', payload)
                }, {
                    editForm: ({onReload}) => h(DeclarationRealEstateForm, {
                        record: record,
                        declarationId: record.declarationId,
                        owner: record.owner,
                        onReload
                    }),
                    viewRecordDialog: ({open, onClose}) => h(ViewRecordDialog, {
                        open: open,
                        data: record.toViewRecordData(),
                        onClose
                    })
                })
            },
        },
    ]

    return {realEstateColumns}
}

