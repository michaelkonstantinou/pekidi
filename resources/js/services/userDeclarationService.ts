import axios from "axios";
import User from "@/models/user";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DeclarationFamilyMember from "@/models/declarationFamilyMember";

export default class UserDeclarationService extends ApiResourceRepository<Declaration>{
    routePrefix = "api/user/declarations"
    model = Declaration
}
