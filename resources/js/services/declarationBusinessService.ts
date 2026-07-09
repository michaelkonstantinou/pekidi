import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationBusiness from "@/models/declarationBusiness";

export default class DeclarationBusinessService extends ApiResourceRepository<DeclarationBusiness>{
    routePrefix = "api/user/declarations/:declarationId/:owner/businesses"
    model = DeclarationBusiness

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
