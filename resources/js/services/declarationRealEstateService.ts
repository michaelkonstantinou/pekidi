import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DeclarationRealEstate from "@/models/declarationRealEstate";

export default class DeclarationRealEstateService extends ApiResourceRepository<DeclarationRealEstate>{
    routePrefix = "api/user/declarations/:declarationId/:owner/real-estates"
    model = DeclarationRealEstate

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
