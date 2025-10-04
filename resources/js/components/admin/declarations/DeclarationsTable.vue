<script setup lang="ts" generic="TData, TValue">
import {onMounted} from "vue";
import {useDeclarationStore} from "@/stores/declarationStore";
import DataTable from "@/components/DataTable.vue";
import {tableColumns} from "@/components/admin/declarations/tableColumns";
import DataTableCreateDialog from "@/components/DataTableCreateDialog.vue";
import DeclarationCreateForm from "@/components/admin/declarations/DeclarationCreateForm.vue";

const declarationStore = useDeclarationStore()

onMounted(async () => {
    await declarationStore.fetchAll()
})

const onRecordCreated = () => {
    console.log("Redirecting to editor")
}
</script>

<template>
<DataTable :data="declarationStore.declarations" :columns="tableColumns">
    <template #buttons>
        <DataTableCreateDialog>
            <DeclarationCreateForm buttonLabel="create" @saved="onRecordCreated"></DeclarationCreateForm>
        </DataTableCreateDialog>
    </template>
</DataTable>
</template>

<style scoped>

</style>
