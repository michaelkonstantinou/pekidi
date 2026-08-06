import axios from "axios";
import Declaration from "@/models/declaration";
import ApiResourceRepository from "@/services/apiResourceRepository";

export default class UserDeclarationService extends ApiResourceRepository<Declaration>{
    routePrefix = "api/user/declarations"
    model = Declaration

    async findLast(): Promise<Declaration | null> {
        try {
            const { data } = await axios.get(this.routePrefix + "-last")

            // Check if data is an empty array or no data are present
            if (!data || (Array.isArray(data) && data.length === 0)) {
                return null
            }

            return new this.model(data)
        } catch (error) {
            return null
        }
    }

    async copyById(id: any): Promise<Declaration | null> {
        try {
            const { data } = await axios.post(this.routePrefix + "/" + id + '/copy')

            // Check if data is an empty array or no data are present
            if (!data || (Array.isArray(data) && data.length === 0)) {
                return null
            }

            return new this.model(data)
        } catch (error) {
            return null
        }
    }
}
