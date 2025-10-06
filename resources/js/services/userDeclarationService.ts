import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";

export default class UserDeclarationService extends ApiResourceRepository<Declaration>{
    routePrefix = "api/user/declarations"
    model = Declaration

    async familyMembers(declarationId: number): Promise<DeclarationFamilyMember[] | null> {
        try {
            const { data } = await axios.get(this.routePrefix + '/' + declarationId + '/family-members')
            return data.map((item: any) => new DeclarationFamilyMember(item))
        } catch (error) {
            return null
        }
    }

    async createFamilyMember(recordValues: any, declarationId: number): Promise<DeclarationFamilyMember | null> {
        try {
            const { data } = await axios.post(this.routePrefix + '/' + declarationId + '/family-members', recordValues)

            return new DeclarationFamilyMember(data)
        } catch (error) {
            throw error
        }
    }

}
