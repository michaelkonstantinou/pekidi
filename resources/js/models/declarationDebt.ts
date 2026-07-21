import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {
    getLocaleCurrencyString,
    getLocaleDateTimeString
} from "@/helpers/localeHelpers";

export default class DeclarationDebt extends AbstractDeclarationOwnerPosition {
    creditorName: string
    debtType: string
    value: number

    constructor(data: any) {
        super(data)

        this.creditorName = data.creditor_name
        this.debtType = data.debt_type
        this.value = data.value
    }

    override toFormValues(): Object {
        return {
            "creditor_name": this.creditorName,
            "debt_type": this.debtType,
            "value": this.value,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem(
                "creditor_name",
                "labels.creditor_name",
                "text",
                "placeholders.creditor_name"
            ),
            new FormFieldItem(
                "debt_type",
                "labels.debt_type",
                "text",
                "placeholders.debt_type"
            ),
            new FormFieldItem(
                "value",
                "labels.value",
                "number",
                "",
                [],
                {"min": 0}
            ),
        ]
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {
                label: "labels.creditor_name",
                value: this.creditorName,
                isLongText: false,
                isMeta: false
            },
            {
                label: "labels.debt_type",
                value: this.debtType,
                isLongText: false,
                isMeta: false
            },
            {
                label: "labels.value",
                value: getLocaleCurrencyString(this.value),
                isLongText: false,
                isMeta: false
            },
            {
                label: "labels.created_at",
                value: getLocaleDateTimeString(this.createdAt),
                isLongText: false,
                isMeta: true
            },
            {
                label: "labels.updated_at",
                value: getLocaleDateTimeString(this.updatedAt),
                isLongText: false,
                isMeta: true
            },
        ]
    }
}
