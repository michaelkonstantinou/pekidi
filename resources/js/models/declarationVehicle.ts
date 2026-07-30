import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {TranslationFunction, ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {FormFieldItem} from "@/dataTypes";
import {toTypedSchema} from "@vee-validate/zod";
import {TypedSchema} from "vee-validate";
import * as z from "zod";

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

    static override getFormValidationSchema(t: TranslationFunction): TypedSchema {
        return toTypedSchema(
            z.object({
                description: z.string().min(1).min(3, t("validation.min_characters", { count: 3 })),
                value: z.number().min(0, t("validation.min_value", { min: 0 })),
            })
        );
    }
}
