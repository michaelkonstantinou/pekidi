import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationAdditionalAsset from "@/models/declarationAdditionalAsset";
import DeclarationDebt from "@/models/declarationDebt";

export default class DeclarationDebtService extends ApiResourceRepository<DeclarationDebt>{
    routePrefix = "api/user/declarations/:declarationId/:owner/debts"
    model = DeclarationDebt

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
