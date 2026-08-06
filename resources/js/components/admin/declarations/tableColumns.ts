import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import Declaration from "@/models/declaration";
import DeclarationsTableActions from "@/components/admin/declarations/DeclarationsTableActions.vue";
import {getCurrentInstance, h} from "vue";
import {useI18n} from "vue-i18n";

export function useDeclarationTableColumns() {
    const {t} = useI18n()

    const tableColumns: ColumnDef<Declaration>[] = [
        makeTextColumn<Declaration>("name", t("labels.name")),
        makeDateColumn<Declaration>("createdAt", t("labels.created_at")),
        makeDateColumn<Declaration>("updatedAt", t("labels.updated_at")),
        {
            id: 'actions',
            enableHiding: false,
            cell: ({ row }) => {
                const record = row.original
                const instance = getCurrentInstance()
                return h(DeclarationsTableActions, {
                    record,
                    onDeleteItem: (payload: any) => instance?.proxy?.$emit('deleteItem', payload),
                    onDuplicateItem: (payload: any) => instance?.proxy?.$emit('duplicateItem', payload)
                })
            },
        },
    ]

    return {tableColumns}
}
