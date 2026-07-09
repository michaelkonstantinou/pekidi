import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationDeposit extends AbstractDeclarationOwnerPosition {
    name: string
    accountNumber: string | null
    value: number

    constructor(data: any) {
        super(data)

        this.name = data.name
        this.accountNumber = data.account_number
        this.value = data.value
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem("name", "labels.name", "text", "placeholders.deposit_name"),
            new FormFieldItem("account_number", "labels.account_number", "text", "placeholders.account_number"),
            new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
        ]
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.name", value: this.name, isLongText: false, isMeta: false},
            {label: "labels.account_number", value: this.accountNumber, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    override toFormValues(): Object {
        return {
            "name": this.name,
            "account_number": this.accountNumber,
            "value": this.value,
        }
    }
}
