export class FormFieldItem {
    name: string;
    type: string;
    label: string;
    placeholder: string;
    options: Array<any>;
    attributes: Object;
    isRequired: boolean;

    constructor(name: string, label: string, type: string = "text", placeholder: string = "", options: any = [], attributes: any = {}, isRequired: boolean = false) {
        this.name = name;
        this.type = type;
        this.label = label;
        this.placeholder = placeholder;
        this.options = options;
        this.attributes = attributes;
        this.isRequired = isRequired
    }
}

export class DebtType {
    static readonly MORTGAGE = "mortgage";
    static readonly HOME_LOAN = "home_loan";
    static readonly VEHICLE_LOAN = "vehicle_loan";
    static readonly BUSINESS_LOAN = "business_loan";
    static readonly STUDENT_LOAN = "student_loan";
    static readonly CREDIT_CARD = "credit_card";
    static readonly TAX_DEBT = "tax_debt";
    static readonly OTHER = "other";

    private static readonly VALUES = [
        DebtType.MORTGAGE,
        DebtType.HOME_LOAN,
        DebtType.VEHICLE_LOAN,
        DebtType.BUSINESS_LOAN,
        DebtType.STUDENT_LOAN,
        DebtType.CREDIT_CARD,
        DebtType.TAX_DEBT,
    ] as const;

    static readonly TRANSLATION_PREFIX: string = 'debt_types'

    /**
     * Returns the list of debt types formatted as options for use in form
     * components such as dropdowns or select inputs.
     *
     * @returns An array of label/value pairs representing all supported debt types.
     */
    static getFormOptions(): Array<{ label: string, value: string }> {
        return [...this.VALUES, DebtType.OTHER].map(value => ({
            label: `${DebtType.TRANSLATION_PREFIX}.${value}`,
            value,
        }));
    }

    /**
     * Determines whether the provided debt type is not one of the predefined
     * supported debt types. This includes the literal value "other" and any
     * custom or unknown debt type.
     *
     * @param value The debt type to evaluate.
     * @returns True if the value is not one of the predefined debt types; otherwise false.
     */
    static isOther(value: string): boolean {
        return !this.VALUES.includes(value as (typeof this.VALUES)[number]);
    }
}
