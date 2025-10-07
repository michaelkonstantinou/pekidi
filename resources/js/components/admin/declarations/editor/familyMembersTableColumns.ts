import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import {getCurrentInstance, h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";
import ViewRecordDialog from "@/components/dialogs/ViewRecordDialog.vue";
import {useI18n} from "vue-i18n";

export function useFamilyMembersTableColumns() {
    const {t} = useI18n()

    const columns: ColumnDef<DeclarationFamilyMember>[] = [
        makeTextColumn<DeclarationFamilyMember>("fullName", t("labels.full_name")),
        makeDateColumn<DeclarationFamilyMember>("bornAt", t("labels.born_at")),
        makeTextColumn<DeclarationFamilyMember>("nationalId", t("labels.national_id")),
        makeTextColumn<DeclarationFamilyMember>("profession", t("labels.profession")),
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
                    editForm: ({onReload}) => h(DeclarationFamilyMemberForm, {
                        record: record,
                        declarationId: record.declarationId,
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

    return {columns}
}

