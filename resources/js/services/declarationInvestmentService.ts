import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationVehicle from "@/models/declarationVehicle";
import DeclarationBusiness from "@/models/declarationBusiness";
import DeclarationInvestment from "@/models/declarationInvestment";

export default class DeclarationInvestmentService extends ApiResourceRepository<DeclarationInvestment>{
    routePrefix = "api/user/declarations/:declarationId/:owner/investments"
    model = DeclarationInvestment

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
