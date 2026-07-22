import { Briefcase, Building2, Car, Landmark, PlusCircle, TrendingUp } from "lucide-vue-next";
import { getLocaleCurrencyString } from "@/helpers/localeHelpers";

// Structure for a single relation's stats (in lowerCamelCase)
export interface RelationSummary {
    count: number;
    totalValue: number;
}

// Inner relation map in raw API response
export interface TotalsPerRelationPayload {
    real_estates?: { count?: number; total_value?: number };
    vehicles?: { count?: number; total_value?: number };
    businesses?: { count?: number; total_value?: number };
    investments?: { count?: number; total_value?: number };
    deposits?: { count?: number; total_value?: number };
    additional_assets?: { count?: number; total_value?: number };
    debts?: { count?: number; total_value?: number };

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
    debts: RelationSummary = { count: 0, totalValue: 0 };

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
            this.debts = this.parseRelation(totals.debts);

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
}

// Complete API Response interface
export interface DeclarationOverviewResponse {
    data: {
        id: number;
        name: string;
        overview: DeclarationOverview;
    }
}
