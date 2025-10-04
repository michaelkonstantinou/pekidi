import {defineStore} from "pinia";
import {type Ref, ref} from "vue";
import Declaration from "@/models/declaration";
import UserDeclarationService from "@/services/userDeclarationService";

export const useDeclarationStore = defineStore('declaration', () => {
    const userDeclarationService = new UserDeclarationService()
    const declarations: Ref<Declaration[]> = ref<Declaration[]>([])

    async function fetchAll() {
        // todo: handle errors
        declarations.value = await userDeclarationService.all() ?? []
    }

    async function create(recordValues: any) {
        const response = await userDeclarationService.create(recordValues)
        if (response !== null) {
            await fetchAll()
            return true;
        }

        return false;
    }
    return {declarations, fetchAll, create}
})
