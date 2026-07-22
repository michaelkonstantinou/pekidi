import axios from 'axios';
import {DeclarationOverview, DeclarationOverviewResponse} from "@/models/declarationOverview";

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

