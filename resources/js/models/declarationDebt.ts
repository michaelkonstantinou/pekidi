import {AbstractDeclarationOwnerPosition} from "@/models/abstractDeclarationOwnerPosition";
import {ViewRecordRow} from "@/types";
import {DebtType, FormFieldItem} from "@/dataTypes";
import {
    getLocaleCurrencyString,
    getLocaleDateTimeString
} from "@/helpers/localeHelpers";

export default class DeclarationDebt extends AbstractDeclarationOwnerPosition {
    creditorName: string
    debtType: string
    value: number

    constructor(data: any) {
        super(data)

        this.creditorName = data.creditor_name
        this.debtType = data.debt_type
        this.value = data.value
    }

    override toFormValues(): Object {
        return {
            "creditor_name": this.creditorName,
            "debt_type": this.debtType,
            "value": this.value,
        }
    }

    static override getFormFieldItems(): FormFieldItem[] {
        return [
            new FormFieldItem(
                "creditor_name",
                "labels.creditor_name",
                "text",
                "placeholders.creditor_name"
            ),
            new FormFieldItem(
                "debt_type",
                "labels.debt_type",
                "select",
                "placeholders.debt_type",
                DebtType.getFormOptions()
            ),
            new FormFieldItem(
                "value",
                "labels.value",
                "number",
                "",
                [],
                {"min": 0}
            ),
        ]
    }

    override toViewRecordData(): ViewRecordRow[] {
        return [
            {
                label: "labels.creditor_name",
                value: this.creditorName,
                isLongText: false,
                isMeta: false
            },
            {
                label: "labels.debt_type",
                value: this.getDebtTypeTranslated(),
                isLongText: false,
                isMeta: false,
                isTranslatable: true,
                translatableOptions: [this.debtType]
            },
            {
                label: "labels.value",
                value: getLocaleCurrencyString(this.value),
                isLongText: false,
                isMeta: false
            },
            {
                label: "labels.created_at",
                value: getLocaleDateTimeString(this.createdAt),
                isLongText: false,
                isMeta: true
            },
            {
                label: "labels.updated_at",
                value: getLocaleDateTimeString(this.updatedAt),
                isLongText: false,
                isMeta: true
            },
        ]
    }

    /**
     * Returns the debt type in a human-readable format
     * In case the provided value is not one of the DebtType options, then it will return Other (<the human input here>)
     * In case the user has selected a value from the options, it will return the option translated
     *
     * @private
     */
    getDebtTypeTranslated(): string {
        if (DebtType.isOther(this.debtType)) {
            return `${DebtType.TRANSLATION_PREFIX}.other_with_value`
        }

        return `${DebtType.TRANSLATION_PREFIX}.${this.debtType}`;
    }
}
