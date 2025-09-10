<script setup lang="ts">

import {SidebarInset, SidebarProvider, SidebarTrigger} from "@/components/ui/sidebar";
import AdminSidebar from "@/views/layouts/AdminSidebar.vue";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList, BreadcrumbPage,
    BreadcrumbSeparator
} from "@/components/ui/breadcrumb";
</script>

<template>
<SidebarProvider>
    <AdminSidebar></AdminSidebar>
    <SidebarInset>
        <header class="flex h-16 shrink-0 items-center gap-2 px-4">
            <SidebarTrigger class="-ml-1" />
            <Separator orientation="vertical" class="mr-2 h-4" />
            <Breadcrumb>
                <BreadcrumbList>
                    <BreadcrumbItem class="hidden md:block">
                        <BreadcrumbLink href="#">
                            Building Your Application
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator class="hidden md:block" />
                    <BreadcrumbItem>
                        <BreadcrumbPage>Data Fetching</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>
        </header>
        <slot />
    </SidebarInset>
</SidebarProvider>
</template>

<style scoped>

</style>
