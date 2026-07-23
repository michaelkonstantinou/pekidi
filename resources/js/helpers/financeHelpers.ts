import {FinancialRiskLevel} from "@/types";
import {DeclarationOverview} from "@/models/declarationOverview";

export function calculateDebtToAssetsRatioForOverview(declarationOverview?: DeclarationOverview): number {
    if (!declarationOverview) {
        return 0.0
    }

    const ratio = calculateDebtToAssetsRatio(
        declarationOverview.totalLiabilitiesValue,
        declarationOverview.totalAssetsValue
    );

    /// Convert decimal to percentage and round to 2 decimal places
    return Math.round((ratio * 100 + Number.EPSILON) * 100) / 100;
}

/**
 * Calculates the Debt-to-Assets Ratio given total liabilities and total assets.
 * Returns the ratio as a decimal (e.g., 0.40 for 40%).
 * Returns 0 if totalAssets is zero or negative to prevent division by zero.
 *
 * @param totalLiabilities - Sum of all debts/liabilities.
 * @param totalAssets - Sum of all assets.
 * @returns The calculated ratio as a decimal number.
 */
export function calculateDebtToAssetsRatio(
    totalLiabilities: number,
    totalAssets: number
): number {
    if (!totalAssets || totalAssets <= 0) {
        return 0;
    }

    return totalLiabilities / totalAssets;
}

/**
 * Determines the financial risk category based on the Debt-to-Assets ratio decimal.
 *
 * - Less than 0.5 (< 50%): "low"
 * - Exactly 0.5 (= 50%): "balanced"
 * - Between 0.5 and 1.0 (50% - 99%): "high"
 * - 1.0 or greater (>= 100%): "insolvent"
 *
 * @returns The corresponding risk string ("low" | "balanced" | "high" | "insolvent").
 * @param percentage
 */
export function getDebtToAssetsRiskLevel(percentage: number): FinancialRiskLevel {
    if (percentage >= 100) {
        return "insolvent";
    }

    if (percentage > 50) {
        return "high";
    }

    if (percentage === 50) {
        return "balanced";
    }

    return "low";
}
