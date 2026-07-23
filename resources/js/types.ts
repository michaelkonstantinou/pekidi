export interface BreadcrumbItemType {
    label: string
    routeName: string
}

export interface ViewRecordRow {
    label: string,
    value: string,
    isLongText: boolean,
    isMeta: boolean,
    isTranslatable?: boolean,
    translatableOptions?: string[]
}

export interface HelpContent {
    main: string,
    tip: string | null
}

export type FinancialRiskLevel = "low" | "balanced" | "high" | "insolvent";

