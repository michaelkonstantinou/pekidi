import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import Declaration from "@/models/declaration";
import DeclarationsTableActions from "@/components/admin/declarations/DeclarationsTableActions.vue";
import {h} from "vue";

export const tableColumns: ColumnDef<Declaration>[] = [
    makeTextColumn<Declaration>("name", "Declaration name"),
    makeDateColumn<Declaration>("createdAt", "Created At"),
    makeDateColumn<Declaration>("updatedAt", "Last update"),
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const record = row.original

            return h('div', { class: 'relative' }, h(DeclarationsTableActions, {
                record,
            }))
        },
    },
]
