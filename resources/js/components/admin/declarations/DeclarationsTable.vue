<script setup lang="ts" generic="TData, TValue">
import {onMounted, ref, Ref} from "vue";
import {useDeclarationStore} from "@/stores/declarationStore";
import DataTable from "@/components/DataTable.vue";
import {useDeclarationTableColumns} from "@/components/admin/declarations/tableColumns";
import DataTableCreateDialog from "@/components/dialogs/DataTableCreateDialog.vue";
import DeclarationCreateForm from "@/components/admin/declarations/DeclarationCreateForm.vue";
import {useRouter} from "vue-router";
import {toast} from "vue-sonner";
import {useI18n} from "vue-i18n";
import {useErrorMessager} from "@/composables/useErrorMessager";

const {t} = useI18n()
const {toastApiErrors} = useErrorMessager()
const declarationStore = useDeclarationStore()
const {tableColumns} = useDeclarationTableColumns()
const router = useRouter()
const isLoading: Ref<boolean> = ref(false)

onMounted(async () => {
    await declarationStore.fetchAll()
})

const onRecordCreated = (id: number) => {
    router.push({'name': 'admin.declarations.edit', 'params': {'id': id}})
}

const onDeleteRecord = (id: number) => {
    isLoading.value = true
    declarationStore.deleteById(id).then(async () => {
        toast.success(t("messages.actions.delete_successful"));
        await declarationStore.fetchAll()
    }).catch(err => toastApiErrors(err))
        .finally(() => isLoading.value=false)
}

const onDuplicateItem = (id: number) => {
    isLoading.value = true
    declarationStore.duplicate(id).then(async (newDeclaration) => {
        toast.success(t("messages.actions.duplicate_successful"));
        await declarationStore.fetchAll()
        await router.push({'name': 'admin.declarations.edit', 'params': {'id': newDeclaration.id}})
    }).catch(err => toastApiErrors(err))
        .finally(() => isLoading.value=false)
}
</script>

<template>
<DataTable :data="declarationStore.declarations" :columns="tableColumns" @deleteItem="onDeleteRecord" @duplicateItem="onDuplicateItem">
    <template #buttons>
        <DataTableCreateDialog>
            <DeclarationCreateForm buttonLabel="create" @saved="onRecordCreated"></DeclarationCreateForm>
        </DataTableCreateDialog>
    </template>
</DataTable>
</template>
