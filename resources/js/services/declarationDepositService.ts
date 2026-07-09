import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationDeposit from "@/models/declarationDeposit";

export default class DeclarationDepositService extends ApiResourceRepository<DeclarationDeposit>{
    routePrefix = "api/user/declarations/:declarationId/:owner/deposits"
    model = DeclarationDeposit

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
