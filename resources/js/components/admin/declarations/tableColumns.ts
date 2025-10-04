import {makeDateColumn, makeTextColumn} from "@/helpers/columnHelpers";
import {ColumnDef} from "@tanstack/vue-table";
import Declaration from "@/models/declaration";

export const tableColumns: ColumnDef<Declaration>[] = [
    makeTextColumn<Declaration>("name", "Declaration name"),
    makeDateColumn<Declaration>("createdAt", "Created At"),
    makeDateColumn<Declaration>("updatedAt", "Last update"),
]
