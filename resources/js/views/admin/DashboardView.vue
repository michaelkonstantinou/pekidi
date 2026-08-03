<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import {BreadcrumbItemType} from "@/types";
import ContinueDeclarationCard from "@/components/admin/widgets/ContinueDeclarationCard.vue";
import {onMounted, Ref, ref} from "vue";
import Declaration from "@/models/declaration";
import UserDeclarationService from "@/services/userDeclarationService";
import {useRouter} from "vue-router";

const breadcrumbs: BreadcrumbItemType[] = [
    {'label': 'Dashboard', routeName: 'admin.dashboard'}
]
const service = new UserDeclarationService()
const router = useRouter()
const lastDeclaration: Ref<Declaration | null> = ref(null)

onMounted(async () => {
    lastDeclaration.value = await service.findLast()
})

function continueLastDeclaration() {
    if (lastDeclaration.value === null) {
        return
    }

    router.push({'name': 'admin.declarations.edit', 'params': {'id': lastDeclaration.value.id}})
}
</script>

<template>
<AdminLayout :breadcrumbs="breadcrumbs">
    <ContinueDeclarationCard v-if="lastDeclaration" :declaration="lastDeclaration" @continue="continueLastDeclaration"/>
</AdminLayout>
</template>

<style scoped>

</style>
