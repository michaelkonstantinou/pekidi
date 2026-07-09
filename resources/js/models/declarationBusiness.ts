import {ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {FormFieldItem} from "@/dataTypes";
import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";

export default class DeclarationBusiness extends AbstractDeclarationOwnerPosition {
    name: string
    businessType: string
    involvementType: string
    value: number

    constructor(data: any) {
        super(data)
        this.name = data.name
        this.businessType = data.business_type
        this.involvementType = data.involvement_type
        this.value = data.value
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.name", value: this.name, isLongText: false, isMeta: false},
            {label: "labels.business_type", value: this.businessType, isLongText: false, isMeta: false},
            {label: "labels.involvement_type", value: this.involvementType, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    override toFormValues(): Object {
        return {
            "name": this.name,
            "business_type": this.businessType,
            "involvement_type": this.involvementType,
            "value": this.value,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem("name", "labels.name", "text", "placeholders.business_name"),
            new FormFieldItem("business_type", "labels.business_type", "text", "placeholders.business_type"),
            new FormFieldItem("involvement_type", "labels.involvement_type", "text", "placeholders.involvement_type"),
            new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
        ]
    }
}
