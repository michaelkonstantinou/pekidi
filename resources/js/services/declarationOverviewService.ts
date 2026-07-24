import axios from 'axios';
import {DeclarationOverview} from "@/models/declarationOverview";
import {DeclarationAssetDistributionChart} from "@/types";

// Complete API Response interface
export interface DeclarationOverviewResponse {
    data: {
        id: number;
        name: string;
        overview: DeclarationOverview;
        asset_distribution: DeclarationAssetDistributionChart;
    };
}

export default class DeclarationOverviewService {

    async getById(declarationId: number): Promise<DeclarationOverview> {
        try {
            const { data } = await axios.get<DeclarationOverviewResponse>(`/api/user/declarations/${declarationId}/overview`);

            // Create an instance populated with API data
            return new DeclarationOverview(data.data.overview);
        } catch (error) {
            console.error('Failed to fetch declaration overview:', error);
            throw error;
        }
    }
}

