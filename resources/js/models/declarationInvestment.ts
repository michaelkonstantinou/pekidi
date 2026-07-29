import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {TranslationFunction, ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {toTypedSchema} from "@vee-validate/zod";
import * as z from "zod";
import {TypedSchema} from "vee-validate";

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

    static override getFormValidationSchema(t: TranslationFunction): TypedSchema {
        const currentYear = new Date().getFullYear();

        return toTypedSchema(
            z.object({
                name: z.string().min(3, t("validation.min_characters", { count: 3 })),
                registration_number: z.string().nullable().optional(),
                country: z.string().nullable().optional(),
                quantity: z
                    .number({ invalid_type_error: t("validation.must_be_number") })
                    .int(t("validation.must_be_integer"))
                    .min(0, t("validation.min_value", { min: 0 })),
                acquisition_type: z.string().nullable().optional(),
                acquisition_year: z
                    .number({ invalid_type_error: t("validation.must_be_number") })
                    .int(t("validation.must_be_integer"))
                    .min(1900, t("validation.min_year", { year: 1900 }))
                    .max(currentYear, t("validation.max_year", { year: currentYear }))
                    .nullable()
                    .optional(),
                value: z
                    .number({ invalid_type_error: t("validation.must_be_number") })
                    .min(0, t("validation.min_value", { min: 0 })),
            })
        );
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
