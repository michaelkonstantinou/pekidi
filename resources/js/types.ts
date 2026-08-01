export interface BreadcrumbItemType {
    label: string
    routeName: string
}

export interface ViewRecordRow {
    label: string,
    value: any,
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

export interface DeclarationNetWorth {
    personal: number,
    joint: number,
    family: number
}

export interface AssetDistributionSeriesItem {

    /** The key representing the asset category (e.g. 'real_estates', 'investments') */
    relation: string;

    /** Raw monetary value for tooltips and calculations */
    total_value: number;

    /** Relative percentage share (e.g. 53.18) */
    percentage: number;

    /** Optional theme color variable override (e.g., 'var(--chart-1)') */
    fill?: string;
}

export interface DeclarationAssetDistributionChart {
    total_assets_value: number;
    series: AssetDistributionSeriesItem[];
}

export interface DeclarationEvaluation {
    strengths: String[];
    weaknesses: String[];
}

export type TranslationFunction = (key: string, params?: Record<string, any>) => string;

export interface ExportOptions {
    documentType: 'official' | 'official_redacted' | 'friendly';
    includePersonal: boolean;
    includeSpouse: boolean;
    includeChildren: boolean;
}
