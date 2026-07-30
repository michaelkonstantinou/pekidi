import {TranslationFunction, ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateTimeString} from "@/helpers/localeHelpers";
import {FormFieldItem} from "@/dataTypes";
import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {toTypedSchema} from "@vee-validate/zod";
import {TypedSchema} from "vee-validate";
import * as z from "zod";

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
            new FormFieldItem("name", "labels.name", "text", "placeholders.business_name", [], {}, true),
            new FormFieldItem("business_type", "labels.business_type", "text", "placeholders.business_type", [], {}, true),
            new FormFieldItem("involvement_type", "labels.involvement_type", "text", "placeholders.involvement_type", [], {}, true),
            new FormFieldItem("value", "labels.value", "number", "", [], { min: 0 }, true),
        ];
    }

    static override getFormValidationSchema(t: TranslationFunction): TypedSchema {
        return toTypedSchema(
            z.object({
                name: z.string().min(1).min(2, t("validation.min_characters", { count: 2 })),
                business_type: z.string().min(1).min(2, t("validation.min_characters", { count: 2 })),
                involvement_type: z.string().min(1).min(2, t("validation.min_characters", { count: 2 })),
                value: z.number().min(0, t("validation.min_value", { min: 0 })),
            })
        );
    }
}
