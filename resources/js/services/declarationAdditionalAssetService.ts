import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationAdditionalAsset from "@/models/declarationAdditionalAsset";

export default class DeclarationAdditionalAssetService extends ApiResourceRepository<DeclarationAdditionalAsset>{
    routePrefix = "api/user/declarations/:declarationId/:owner/additional-assets"
    model = DeclarationAdditionalAsset

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
