import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";
import DeclarationRealEstate from "@/models/declarationRealEstate";
import DeclarationVehicle from "@/models/declarationVehicle";

export default class DeclarationVehicleService extends ApiResourceRepository<DeclarationVehicle>{
    routePrefix = "api/user/declarations/:declarationId/:owner/vehicles"
    model = DeclarationVehicle

    constructor(declarationId: number, owner: string) {
        super();
        this.routePrefix = this.routePrefix
            .replace(":declarationId", declarationId.toString())
            .replace(':owner', owner)
    }
}
