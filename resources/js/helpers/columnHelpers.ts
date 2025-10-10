import {h} from "vue";
import {ColumnDef, Row} from "@tanstack/vue-table";
import {getLocale, getLocaleCurrencyString, getLocaleDateString} from "@/helpers/localeHelpers";

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
