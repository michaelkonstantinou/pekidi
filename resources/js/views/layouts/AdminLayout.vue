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
import {BreadcrumbItemType} from "@/types";
import {Separator} from "@/components/ui/separator";
import {PropType} from "vue";

const props = defineProps({
    breadcrumbs: {
        type: Array as PropType<BreadcrumbItemType[]>,
        required: false,
        default: []
    }
})
</script>

<template>
<SidebarProvider>
    <AdminSidebar></AdminSidebar>
    <SidebarInset>
        <header class="flex h-16 shrink-0 items-center gap-2 px-4">
            <SidebarTrigger class="-ml-1" />
            <Breadcrumb>
                <BreadcrumbList>
                    <template v-for="(item, index) in breadcrumbs" :key="index">
                        <BreadcrumbItem>
                            <template v-if="index === breadcrumbs.length - 1">
                                <BreadcrumbPage>{{ $t(item.label) }}</BreadcrumbPage>
                            </template>
                            <template v-else>
                                <BreadcrumbLink as-child>
                                    <router-link :to="item.routeName !== null ? {'name': item.routeName} : '#'">
                                        {{ $t(item.label) }}
                                    </router-link>
                                </BreadcrumbLink>
                            </template>
                        </BreadcrumbItem>
                        <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
                    </template>
                </BreadcrumbList>
            </Breadcrumb>
        </header>
        <Separator />
        <slot />
    </SidebarInset>
</SidebarProvider>
</template>

<style scoped>

</style>
