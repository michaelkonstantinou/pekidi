import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {FormFieldItem} from "@/dataTypes";

export default class DeclarationVehicle extends AbstractDeclarationOwnerPosition {
    description: string
    value: number

    constructor(data: any) {
        super(data)

        this.description = data.description
        this.value = data.value
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.description", value: this.description, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    override toFormValues(): Object {
        return {
            "value": this.value,
            "description": this.description,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem("description", "labels.description", "text", "placeholders.vehicle_description"),
            new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
        ]
    }
}
