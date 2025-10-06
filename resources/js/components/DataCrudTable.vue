<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {useErrorMessager} from "@/composables/useErrorMessager";
import {onMounted, ref, Ref} from "vue";
import {toast} from "vue-sonner";
import AlertError from "@/components/AlertError.vue";
import DataTable from "@/components/DataTable.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";

const {t} = useI18n()
const {toastApiErrors} = useErrorMessager()
const props = defineProps({
    apiService: {
        required: true,
        type: ApiResourceRepository
    },
    columns: {
        required: true
    },
    compact: {
        required: false,
        type: Boolean,
        default: true
    }
})

const isLoading: Ref<boolean> = ref(false)
const rows = ref<Array>([]);
const errors = ref<String[]>([])

onMounted(async() => {
    await loadData()
})

async function loadData() {
    isLoading.value = true;
    const data = await props.apiService.all()
    if (data === null) {
        errors.value.push(t("errors.could_not_load_data"))
    } else {
        rows.value = data
    }
    isLoading.value = false;
}

function onDeleteItem(primaryKey: number) {
    isLoading.value = true
    props.apiService.deleteById(primaryKey).then(async () => {
        toast.success(t("actions.delete_successful"));
        await loadData()
    }).catch(err => toastApiErrors(err))
        .finally(() => isLoading.value=false)
}
</script>

<template>
    <AlertError :errors="errors"/>
    <DataTable :data="rows" :columns="columns" :compact="compact" @reload="loadData" @deleteItem="onDeleteItem">
        <template #buttons>
            <slot name="buttons"></slot>
        </template>
    </DataTable>
</template>

<style scoped>

</style>
