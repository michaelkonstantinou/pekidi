import {
    Briefcase,
    Building2,
    Car,
    Landmark,
    PlusCircle,
    TrendingUp,
    Home,
    GraduationCap,
    CreditCard,
    Receipt,
    CircleHelp,
    AlertCircle
} from "lucide-vue-next";
import { getLocaleCurrencyString } from "@/helpers/localeHelpers";
import { DebtType } from "@/dataTypes"; // Adjust path if needed

// Structure for a single relation's stats (in lowerCamelCase)
export interface RelationSummary {
    count: number;
    totalValue: number;
}

// Breakdown dictionary for debts grouped by type
export interface DebtTypeBreakdown {
    [type: string]: RelationSummary;
}

// Structure for debts which includes total count, value, and breakdown per debt_type
export interface DebtSummary extends RelationSummary {
    byType: DebtTypeBreakdown;
}

// Raw payload for debts coming from backend API
export interface DebtPayload {
    count?: number;
    total_value?: number;
    totalValue?: number;
    by_type?: Record<string, { count?: number; total_value?: number; totalValue?: number }>;
    byType?: Record<string, { count?: number; total_value?: number; totalValue?: number }>;
}

// Inner relation map in raw API response
export interface TotalsPerRelationPayload {
    real_estates?: { count?: number; total_value?: number };
    vehicles?: { count?: number; total_value?: number };
    businesses?: { count?: number; total_value?: number };
    investments?: { count?: number; total_value?: number };
    deposits?: { count?: number; total_value?: number };
    additional_assets?: { count?: number; total_value?: number };
    debts?: DebtPayload;

    // Support camelCase payloads as well
    realEstates?: RelationSummary;
    additionalAssets?: RelationSummary;
}

// Raw API payload coming in snake_case from Laravel
export interface DeclarationOverviewApiPayload {
    totals_per_relation?: TotalsPerRelationPayload;
    total_assets_value?: number;
    total_liabilities_value?: number;

    // Support camelCase variants
    totalsPerRelation?: TotalsPerRelationPayload;
    totalAssetsValue?: number;
    totalLiabilitiesValue?: number;
}

export class DeclarationOverview {
    realEstates: RelationSummary = { count: 0, totalValue: 0 };
    vehicles: RelationSummary = { count: 0, totalValue: 0 };
    businesses: RelationSummary = { count: 0, totalValue: 0 };
    investments: RelationSummary = { count: 0, totalValue: 0 };
    deposits: RelationSummary = { count: 0, totalValue: 0 };
    additionalAssets: RelationSummary = { count: 0, totalValue: 0 };
    debts: DebtSummary = { count: 0, totalValue: 0, byType: {} };

    totalAssetsValue: number = 0;
    totalLiabilitiesValue: number = 0;

    constructor(init?: DeclarationOverviewApiPayload) {
        if (init) {
            const totals = init.totals_per_relation ?? init.totalsPerRelation ?? {};

            this.realEstates = this.parseRelation(totals.realEstates ?? totals.real_estates);
            this.vehicles = this.parseRelation(totals.vehicles);
            this.businesses = this.parseRelation(totals.businesses);
            this.investments = this.parseRelation(totals.investments);
            this.deposits = this.parseRelation(totals.deposits);
            this.additionalAssets = this.parseRelation(totals.additionalAssets ?? totals.additional_assets);

            this.debts = this.parseDebtRelation(totals.debts);

            this.totalAssetsValue = init.totalAssetsValue ?? init.total_assets_value ?? 0;
            this.totalLiabilitiesValue = init.totalLiabilitiesValue ?? init.total_liabilities_value ?? 0;
        }
    }

    /**
     * Helper to normalize raw objects (whether snake_case or camelCase) into RelationSummary
     */
    private parseRelation(data?: { count?: number; total_value?: number; totalValue?: number }): RelationSummary {
        return {
            count: data?.count ?? 0,
            totalValue: data?.totalValue ?? data?.total_value ?? 0,
        };
    }

    /**
     * Helper to parse debt object including by_type map
     */
    private parseDebtRelation(data?: DebtPayload): DebtSummary {
        const summary = this.parseRelation(data);
        const rawByType = data?.byType ?? data?.by_type ?? {};
        const parsedByType: DebtTypeBreakdown = {};

        for (const [typeKey, typeData] of Object.entries(rawByType)) {
            parsedByType[typeKey] = this.parseRelation(typeData);
        }

        return {
            ...summary,
            byType: parsedByType,
        };
    }

    getAssets(): Array<{ label: string; amount: string; icon: any; units: number }> {
        return [
            {
                label: "titles.real_estate",
                amount: getLocaleCurrencyString(this.realEstates.totalValue),
                icon: Building2,
                units: this.realEstates.count,
            },
            {
                label: "titles.vehicles",
                amount: getLocaleCurrencyString(this.vehicles.totalValue),
                icon: Car,
                units: this.vehicles.count,
            },
            {
                label: "titles.businesses",
                amount: getLocaleCurrencyString(this.businesses.totalValue),
                icon: Briefcase,
                units: this.businesses.count,
            },
            {
                label: "titles.investments",
                amount: getLocaleCurrencyString(this.investments.totalValue),
                icon: TrendingUp,
                units: this.investments.count,
            },
            {
                label: "titles.deposits",
                amount: getLocaleCurrencyString(this.deposits.totalValue),
                icon: Landmark,
                units: this.deposits.count,
            },
            {
                label: "titles.additional_assets",
                amount: getLocaleCurrencyString(this.additionalAssets.totalValue),
                icon: PlusCircle,
                units: this.additionalAssets.count,
            },
        ];
    }

    /**
     * Map each predefined DebtType to a dedicated Lucide icon
     */
    private getDebtIcon(debtType: string): any {
        switch (debtType) {
            case DebtType.MORTGAGE:
                return Building2;
            case DebtType.HOME_LOAN:
                return Home;
            case DebtType.VEHICLE_LOAN:
                return Car;
            case DebtType.BUSINESS_LOAN:
                return Briefcase;
            case DebtType.STUDENT_LOAN:
                return GraduationCap;
            case DebtType.CREDIT_CARD:
                return CreditCard;
            case DebtType.TAX_DEBT:
                return Receipt;
            case DebtType.OTHER:
                return CircleHelp;
            default:
                return AlertCircle;
        }
    }

    /**
     * Returns a complete list of all DebtType options.
     * Guarantees all standard DebtType options are rendered, collapsing any unrecognized/custom
     * types into the "other" category.
     */
    getLiabilities(): Array<{ label: string; amount: string; icon: any; units: number; typeKey: string }> {
        const predefinedOptions = DebtType.getFormOptions();

        // 1. Create a shallow aggregated map where unrecognized types accumulate into 'other'
        const aggregatedByType: Record<string, RelationSummary> = {};

        for (const [typeKey, summary] of Object.entries(this.debts.byType)) {
            const targetKey = DebtType.isOther(typeKey) ? DebtType.OTHER : typeKey;

            if (!aggregatedByType[targetKey]) {
                aggregatedByType[targetKey] = { count: 0, totalValue: 0 };
            }

            aggregatedByType[targetKey].count += summary.count;
            aggregatedByType[targetKey].totalValue += summary.totalValue;
        }

        // 2. Map standard options directly using the normalized breakdown dictionary
        return predefinedOptions.map((option) => {
            const summary = aggregatedByType[option.value] ?? { count: 0, totalValue: 0 };

            return {
                typeKey: option.value,
                label: option.label,
                amount: getLocaleCurrencyString(summary.totalValue),
                icon: this.getDebtIcon(option.value),
                units: summary.count,
            };
        });
    }
}

// Complete API Response interface
export interface DeclarationOverviewResponse {
    data: {
        id: number;
        name: string;
        overview: DeclarationOverview;
    };
}
