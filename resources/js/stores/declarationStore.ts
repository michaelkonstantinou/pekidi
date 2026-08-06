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
            return response;
        }

        return null;
    }

    async function duplicate(id: number) {
        const response = await userDeclarationService.copyById(id);

        if (response === null) {
            throw new Error(`Failed to duplicate declaration with id: ${id}`);
        }

        await fetchAll();
        return response; // Resolves with the new Declaration object
    }

    async function update(recordValues: any, id: number) {
        recordValues.id = id
        const response = await userDeclarationService.update(recordValues)
        if (response !== null) {
            await fetchAll()
            return response;
        }

        return null;
    }

    function fetchById(id: number) {
        return userDeclarationService.findById(id)
    }

    function deleteById(id: number) {
        return userDeclarationService.deleteById(id)
    }

    return {declarations, fetchAll, create, fetchById, update, deleteById, duplicate}
})
