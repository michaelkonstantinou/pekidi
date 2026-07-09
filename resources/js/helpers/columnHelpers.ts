import {Component, getCurrentInstance, h} from "vue";
import {ColumnDef, Row} from "@tanstack/vue-table";
import {getLocale, getLocaleCurrencyString, getLocaleDateString} from "@/helpers/localeHelpers";
import ViewRecordDialog from "@/components/dialogs/ViewRecordDialog.vue";
import DataTableCrudActions from "@/components/DataTableCrudActions.vue";

export function makeDateColumn<T extends Record<string, any>>(
    key: keyof T,
    label?: string
): ColumnDef<T> {
    return {
        accessorKey: key as string,
        header: () => h("div", {}, label ?? key.toString()),
        cell: ({ row }) => {
            const raw = row.getValue(key as string) as Date
            const formatted = getLocaleDateString(raw)

            return h("div", {}, formatted)
        },
    }
}

export function makeTextColumn<T extends Record<string, any>>(
    key: keyof T,
    label?: string
): ColumnDef<T> {
    return {
        accessorKey: key as string,
        header: () => h("div", {}, label ?? key.toString()),
        cell: ({ row }) => h("div", {}, row.getValue(key as string)),
    }
}

export function makeCurrencyColumn<T extends Record<string, any>>(
    key: keyof T,
    label?: string
): ColumnDef<T> {
    return {
        accessorKey: key as string,
        header: () => h("div", {}, label ?? key.toString()),
        cell: ({ row }) => h("div", {}, getLocaleCurrencyString(row.getValue(key as string))),
    }
}

export function makeActionsColumn<T>(
    FormComponent: Component,
    getFormProps: (record: T) => Record<string, unknown>,
) {
    return {
        id: 'actions',
        enableHiding: false,

        cell: ({ row }: any) => {
            const record = row.original as T
            const instance = getCurrentInstance()
            return h(
                DataTableCrudActions,
                {
                    primaryKey: record.id,
                    onDeleteItem: (payload: any) => instance?.proxy?.$emit('deleteItem', payload),
                    onReload: (payload: any) => instance?.proxy?.$emit('reload', payload)
                },
                {
                    editForm: ({ onReload }: any) =>
                        h(FormComponent, {
                            ...getFormProps(record),
                            onReload,
                        }),

                    viewRecordDialog: ({ open, onClose }: any) =>
                        h(ViewRecordDialog, {
                            open,
                            data: record.toViewRecordData(),
                            onClose,
                        }),
                },
            )
        },
    }
}
