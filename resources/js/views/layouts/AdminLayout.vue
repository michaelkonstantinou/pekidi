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
import AdminSwitchLocale from "@/views/layouts/AdminSwitchLocale.vue";

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
        <!-- Brand Contextual Sidebar Navigation -->
        <AdminSidebar />

        <!-- Main Right Hand Application Canvas -->
        <SidebarInset class="flex flex-col min-h-screen bg-background text-foreground transition-colors duration-150">

            <!-- Top Functional Application Bar -->
            <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center justify-between bg-white border-b border-neutral-200/80 px-6 shadow-sm dark:bg-card dark:border-border dark:shadow-none transition-all">

                <!-- Left Wing controls group containing triggers and path tracking matrix -->
                <div class="flex items-center gap-3">
                    <SidebarTrigger class="-ml-1 text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted rounded-default transition-all duration-150" />

                    <div class="h-4 w-[1px] bg-neutral-200 dark:bg-border mx-1 hidden sm:block"></div>

                    <!-- Dynamic System Path Map Navigation Trackers mapped to system design tokens -->
                    <Breadcrumb class="hidden sm:inline-block">
                        <BreadcrumbList class="flex items-center gap-1.5 text-sm font-sans font-medium tracking-normal">
                            <template v-for="(item, index) in breadcrumbs" :key="index">
                                <BreadcrumbItem>
                                    <template v-if="index === breadcrumbs.length - 1">
                                        <!-- Final Active Route -->
                                        <BreadcrumbPage class="text-neutral-900 font-semibold dark:text-foreground transition-colors">
                                            {{ $t(item.label) }}
                                        </BreadcrumbPage>
                                    </template>
                                    <template v-else>
                                        <BreadcrumbLink as-child>
                                            <router-link
                                                :to="item.routeName !== null ? {'name': item.routeName} : '#'"
                                                class="text-neutral-500 hover:text-neutral-800 dark:text-muted-foreground dark:hover:text-foreground transition-colors"
                                            >
                                                {{ $t(item.label) }}
                                            </router-link>
                                        </BreadcrumbLink>
                                    </template>
                                </BreadcrumbItem>
                                <BreadcrumbSeparator
                                    v-if="index !== breadcrumbs.length - 1"
                                    class="text-neutral-300 dark:text-border font-normal scale-90 mx-0.5"
                                />
                            </template>
                        </BreadcrumbList>
                    </Breadcrumb>
                </div>

                <!-- Right Wing Infrastructure Core Integration Controls Panel -->
                <div class="flex items-center gap-4">
                    <AdminSwitchLocale />
                </div>

            </header>

            <!-- Primary Content Body Slot Wrapper Canvas -->
            <main class="flex-1 p-6 md:p-8 max-w-[1600px] w-full mx-auto">
                <slot />
            </main>

        </SidebarInset>
    </SidebarProvider>
</template>
