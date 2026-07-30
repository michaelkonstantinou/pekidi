import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {TranslationFunction, ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {toTypedSchema} from "@vee-validate/zod";
import {TypedSchema} from "vee-validate";
import * as z from "zod";

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

    override toFormValues(): Object {
        return {
            "name": this.name,
            "asset_type": this.assetType,
            "registration_number": this.registrationNumber,
            "acquisition_type": this.acquisitionType,
            "acquisition_year": this.acquisitionYear,
            "value": this.value,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        const currentYear = new Date().getFullYear();

        return [
            new FormFieldItem("name", "labels.name", "text", "placeholders.asset_name", [], {}, true),
            new FormFieldItem("asset_type", "labels.asset_type", "text", "placeholders.asset_type", [], {}, true),
            new FormFieldItem("registration_number", "labels.registration_number", "text", "placeholders.registration_number", [], {}, false),
            new FormFieldItem("acquisition_type", "labels.acquisition_type", "text", "placeholders.acquisition_type", [], {}, false),
            new FormFieldItem(
                "acquisition_year",
                "labels.acquisition_year",
                "number",
                "placeholders.acquisition_year",
                [],
                { min: 1900, max: currentYear },
                false
            ),
            new FormFieldItem("value", "labels.value", "number", "", [], { min: 0 }, true),
        ];
    }

    static override getFormValidationSchema(t: TranslationFunction): TypedSchema {
        const currentYear = new Date().getFullYear();

        return toTypedSchema(
            z.object({
                // min(1) triggers validation.required from global error map
                name: z
                    .string()
                    .min(1)
                    .min(3, t("validation.min_characters", { count: 3 })),
                asset_type: z.string().min(1),
                registration_number: z.string().nullable().optional(),
                acquisition_type: z.string().nullable().optional(),
                acquisition_year: z
                    .number()
                    .int(t("validation.must_be_integer"))
                    .min(1900, t("validation.min_year", { year: 1900 }))
                    .max(currentYear, t("validation.max_year", { year: currentYear }))
                    .nullable()
                    .optional(),
                value: z.number().min(0, t("validation.min_value", { min: 0 })),
            })
        );
    }
}
