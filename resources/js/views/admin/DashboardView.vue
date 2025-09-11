<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import {BreadcrumbItemType} from "@/types";
import Heading from "@/components/Heading.vue";
import { Separator } from '@/components/ui/separator';

const breadcrumbs: BreadcrumbItemType[] = [
    {'label': 'Dashboard', routeName: 'admin.dashboard'}
]
</script>

<template>
<AdminLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 py-6">
        <Heading title="Settings" description="Manage your profile and account settings"/>

        <Separator class="my-6" />
    </div>

    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
        <h1>Hey you are logged in!</h1>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="aspect-video rounded-xl bg-muted/50" />
            <div class="aspect-video rounded-xl bg-muted/50" />
            <div class="aspect-video rounded-xl bg-muted/50" />
        </div>
        <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" />
    </div>

</AdminLayout>
</template>

<style scoped>

</style>
