import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";

export default class UserDeclarationService extends ApiResourceRepository<Declaration>{
    routePrefix = "api/user/declarations"
    model = Declaration

    async findLast(): Promise<Declaration | null> {
        try {
            const { data } = await axios.get(this.routePrefix + "-last")

            // Check if data is an empty array or no data are present
            if (!data || (Array.isArray(data) && data.length === 0)) {
                return null
            }

            return new this.model(data)
        } catch (error) {
            return null
        }
    }
}
