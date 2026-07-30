import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {TranslationFunction, ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {FormFieldItem} from "@/dataTypes";
import {toTypedSchema} from "@vee-validate/zod";
import {TypedSchema} from "vee-validate";
import * as z from "zod";

export default class DeclarationRealEstate extends AbstractDeclarationOwnerPosition {
    location: string
    realEstateType: string
    area: number
    acquisitionType: string
    acquisitionYear: number
    acquisitionValue: number
    currentValue: number
    rightsEncumbrances: string

    constructor(data: any) {
        super(data)

        this.location = data.location
        this.area = data.area
        this.realEstateType = data.real_estate_type
        this.acquisitionType = data.acquisition_type
        this.acquisitionYear = data.acquisition_year
        this.acquisitionValue = data.acquisition_value
        this.currentValue = data.current_value
        this.rightsEncumbrances = data.rights_encumbrances
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.location", value: this.location, isLongText: false, isMeta: false},
            {label: "labels.real_estate_type", value: this.realEstateType, isLongText: false, isMeta: false},
            {label: "labels.area", value: this.area.toString(), isLongText: false, isMeta: false},
            {label: "labels.acquisition_type", value: this.acquisitionType, isLongText: false, isMeta: false},
            {label: "labels.acquisition_year", value: this.acquisitionYear.toString(), isLongText: false, isMeta: false},
            {label: "labels.acquisition_value", value: getLocaleCurrencyString(this.acquisitionValue), isLongText: false, isMeta: false},
            {label: "labels.current_value", value: getLocaleCurrencyString(this.currentValue), isLongText: false, isMeta: false},
            {label: "labels.rights_encumbrances", value: this.rightsEncumbrances, isLongText: true, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }

    override toFormValues(): Object {
        return {
            "location": this.location,
            "area": this.area,
            "real_estate_type": this.realEstateType,
            "acquisition_type": this.acquisitionType,
            "acquisition_year": this.acquisitionYear,
            "acquisition_value": this.acquisitionValue,
            "current_value": this.currentValue,
            "rights_encumbrances": this.rightsEncumbrances,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        const currentYear = new Date().getFullYear();

        return [
            new FormFieldItem("location", "labels.location", "text", "placeholders.location", [], {}, true),
            new FormFieldItem("area", "labels.area", "number", "", [], { min: 1 }, true),
            new FormFieldItem("real_estate_type", "labels.real_estate_type", "text", "placeholders.real_estate_type", [], {}, true),
            new FormFieldItem("acquisition_type", "labels.acquisition_type", "text", "placeholders.acquisition_type", [], {}, true),
            new FormFieldItem(
                "acquisition_year",
                "labels.acquisition_year",
                "number",
                "",
                [],
                { min: 1800, max: currentYear },
                true
            ),
            new FormFieldItem("acquisition_value", "labels.acquisition_value", "number", "", [], { min: 0 }, true),
            new FormFieldItem("current_value", "labels.current_value", "number", "", [], { min: 0 }, true),
            new FormFieldItem("rights_encumbrances", "labels.rights_encumbrances", "textarea", "placeholders.rights_encumbrances", [], {}, true),
        ];
    }

    static override getFormValidationSchema(t: TranslationFunction): TypedSchema {
        const currentYear = new Date().getFullYear();

        return toTypedSchema(
            z.object({
                location: z.string().min(1),
                real_estate_type: z.string().min(1),
                area: z.number().min(1, t("validation.min_value", { min: 1 })),
                acquisition_type: z.string().min(1),
                acquisition_year: z
                    .number()
                    .int(t("validation.must_be_integer"))
                    .min(1800, t("validation.min_year", { year: 1800 }))
                    .max(currentYear, t("validation.max_year", { year: currentYear })),
                acquisition_value: z.number().min(0, t("validation.min_value", { min: 0 })),
                current_value: z.number().min(0, t("validation.min_value", { min: 0 })),
                rights_encumbrances: z.string().min(1),
            })
        );
    }
}
