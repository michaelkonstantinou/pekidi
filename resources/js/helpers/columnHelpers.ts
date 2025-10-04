import {h} from "vue";
import {ColumnDef, Row} from "@tanstack/vue-table";

export function makeDateColumn<T extends Record<string, any>>(
    key: keyof T,
    label?: string
): ColumnDef<T> {
    return {
        accessorKey: key as string,
        header: () => h("div", {}, label ?? key.toString()),
        cell: ({ row }) => {
            const raw = row.getValue(key as string) as Date
            const formatted = raw.toLocaleDateString()

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
