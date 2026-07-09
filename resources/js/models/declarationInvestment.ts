import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationInvestment extends AbstractDeclarationOwnerPosition {
    name: string
    registrationNumber: string | null
    country: string | null
    quantity: number
    acquisitionType: string | null
    acquisitionYear: number | null
    value: number

    constructor(data: any) {
        super(data)

        this.name = data.name
        this.registrationNumber = data.registration_number
        this.country = data.country
        this.quantity = data.quantity
        this.acquisitionType = data.acquisition_type
        this.acquisitionYear = data.acquisition_year
        this.value = data.value
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem("name", "labels.name", "text", "placeholders.investment_name"),
            new FormFieldItem("registration_number", "labels.registration_number", "text", "placeholders.registration_number"),
            new FormFieldItem("country", "labels.country", "text", "placeholders.country"),
            new FormFieldItem("quantity", "labels.quantity", "number", "placeholders.quantity", [], {"min": 0}),
            new FormFieldItem("acquisition_type", "labels.acquisition_type", "text", "placeholders.acquisition_type"),
            new FormFieldItem("acquisition_year", "labels.acquisition_year", "number", "placeholders.acquisition_year", [], {
                "min": 1900,
                "max": new Date().getFullYear()
            }),
            new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
        ]
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.name", value: this.name, isLongText: false, isMeta: false},
            {label: "labels.registration_number", value: this.registrationNumber, isLongText: false, isMeta: false},
            {label: "labels.country", value: this.country, isLongText: false, isMeta: false},
            {label: "labels.quantity", value: this.quantity, isLongText: false, isMeta: false},
            {label: "labels.acquisition_type", value: this.acquisitionType, isLongText: false, isMeta: false},
            {label: "labels.acquisition_year", value: this.acquisitionYear, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    override toFormValues(): Object {
        return {
            "name": this.name,
            "registration_number": this.registrationNumber,
            "country": this.country,
            "quantity": this.quantity,
            "acquisition_type": this.acquisitionType,
            "acquisition_year": this.acquisitionYear,
            "value": this.value,
        }
    }
}
