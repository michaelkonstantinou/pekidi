<script setup lang="ts">
import {useI18n} from "vue-i18n";
import {useErrorMessager} from "@/composables/useErrorMessager";
import {onMounted, PropType, ref, Ref} from "vue";
import {toast} from "vue-sonner";
import AlertError from "@/components/AlertError.vue";
import DataTable from "@/components/DataTable.vue";
import ApiResourceRepository from "@/services/apiResourceRepository";
import DataTableCreateDialog from "@/components/dialogs/DataTableCreateDialog.vue";
import {Button} from "@/components/ui/button";
import {CircleQuestionMark} from "lucide-vue-next"
import DataTableHelpDialog from "@/components/dialogs/DataTableHelpDialog.vue";
import {HelpContent} from "@/types";

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
    },
    title: {
        required: false,
        type: String,
    },
    helpContent: {
        required: false,
        type: Object as PropType<HelpContent>,
        default: null
    }
})

const isLoading: Ref<boolean> = ref(false)
const rows = ref([]);
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
        toast.success(t("messages.actions.delete_successful"));
        await loadData()
    }).catch(err => toastApiErrors(err))
        .finally(() => isLoading.value=false)
}

const isHelpDialogOpen = ref(false)
</script>

<template>
    <AlertError :errors="errors"/>
    <DataTable :data="rows" :columns="columns" :compact="compact" @reload="loadData" @deleteItem="onDeleteItem" :title="title">
        <template #buttons>
            <DataTableCreateDialog :isLoading="isLoading" >
                <slot name="createForm"></slot>
            </DataTableCreateDialog>
            <DataTableHelpDialog v-if="helpContent !== null"
                                 :content="helpContent"
                                 @open="isHelpDialogOpen = true"
                                 @close="isHelpDialogOpen = false"
                                 :isOpen="isHelpDialogOpen"/>
        </template>
    </DataTable>
</template>

<style scoped>

</style>
