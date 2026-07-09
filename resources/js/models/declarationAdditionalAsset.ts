import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationAdditionalAsset extends AbstractDeclarationOwnerPosition {
    name: string
    assetType: string
    registrationNumber: string | null
    acquisitionType: string | null
    acquisitionYear: number | null
    value: number

    constructor(data: any) {
        super(data)

        this.name = data.name
        this.assetType = data.asset_type
        this.registrationNumber = data.registration_number
        this.acquisitionType = data.acquisition_type
        this.acquisitionYear = data.acquisition_year
        this.value = data.value
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.name", value: this.name, isLongText: false, isMeta: false},
            {label: "labels.asset_type", value: this.assetType, isLongText: false, isMeta: false},
            {label: "labels.registration_number", value: this.registrationNumber, isLongText: false, isMeta: false},
            {label: "labels.acquisition_type", value: this.acquisitionType, isLongText: false, isMeta: false},
            {label: "labels.acquisition_year", value: this.acquisitionYear, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem("name", "labels.name", "text", "placeholders.asset_name"),
            new FormFieldItem("asset_type", "labels.asset_type", "text", "placeholders.asset_type"),
            new FormFieldItem("registration_number", "labels.registration_number", "text", "placeholders.registration_number"),
            new FormFieldItem("acquisition_type", "labels.acquisition_type", "text", "placeholders.acquisition_type"),
            new FormFieldItem(
                "acquisition_year",
                "labels.acquisition_year",
                "number",
                "placeholders.acquisition_year",
                [],
                {"min": 1900, "max": new Date().getFullYear()}
            ),
            new FormFieldItem("value", "labels.value", "number", "", [], {"min": 0}),
        ]
    }
}
