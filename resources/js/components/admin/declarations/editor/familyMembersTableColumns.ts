import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import Declaration from "@/models/declaration";
import DeclarationsTableActions from "@/components/admin/declarations/DeclarationsTableActions.vue";
import {h} from "vue";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";

export const familyMembersTableColumns: ColumnDef<DeclarationFamilyMember>[] = [
    makeTextColumn<DeclarationFamilyMember>("fullName", "Full name"),
    makeDateColumn<DeclarationFamilyMember>("bornAt", "Date of Birth"),
    makeTextColumn<DeclarationFamilyMember>("nationalId", "National Id"),
    makeTextColumn<DeclarationFamilyMember>("profession", "Profession"),
    // {
    //     id: 'actions',
    //     enableHiding: false,
    //     cell: ({ row }) => {
    //         const record = row.original
    //
    //         return h('div', { class: 'relative' }, h(DeclarationsTableActions, {
    //             record,
    //         }))
    //     },
    // },
]
