import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";

export default class DeclarationFamilyMembersService extends ApiResourceRepository<DeclarationFamilyMember>{
    routePrefix = "api/user/declarations/:declarationId/family-members"
    model = DeclarationFamilyMember

    constructor(declarationId: number) {
        super();
        this.routePrefix = this.routePrefix.replace(":declarationId", declarationId.toString())
    }
}
