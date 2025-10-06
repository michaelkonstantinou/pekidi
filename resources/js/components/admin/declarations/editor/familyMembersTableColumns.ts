import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import Declaration from "@/models/declaration";
import DeclarationsTableActions from "@/components/admin/declarations/DeclarationsTableActions.vue";
import {getCurrentInstance, h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";
import DeclarationFamilyMemberForm from "@/components/admin/declarations/editor/DeclarationFamilyMemberForm.vue";

export const familyMembersTableColumns: ColumnDef<DeclarationFamilyMember>[] = [
    makeTextColumn<DeclarationFamilyMember>("fullName", "Full name"),
    makeDateColumn<DeclarationFamilyMember>("bornAt", "Date of Birth"),
    makeTextColumn<DeclarationFamilyMember>("nationalId", "National Id"),
    makeTextColumn<DeclarationFamilyMember>("profession", "Profession"),
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
                })
            })
        },
    },
]
