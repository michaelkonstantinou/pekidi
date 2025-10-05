<script setup lang="ts">

import Heading from "@/components/Heading.vue";
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import {Separator} from "@/components/ui/separator";
import {BreadcrumbItemType} from "@/types";
import DeclarationsTable from "@/components/admin/declarations/DeclarationsTable.vue";

const breadcrumbs: BreadcrumbItemType[] = [
    {'label': 'Dashboard', routeName: 'admin.dashboard'},
    {'label': 'Declarations', routeName: ''}
]
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Declarations" description="Manage your declarations"/>

            <Separator class="my-6" />
        </div>

        <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
            <div class="flex gap-2">
                <h3 class="scroll-m-20 text-2xl font-semibold tracking-tight">All Declarations</h3>
            </div>

            <DeclarationsTable />
        </div>

    </AdminLayout>
</template>

<style scoped>

</style>
