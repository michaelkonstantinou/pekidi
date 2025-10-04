<script setup lang="ts">
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarHeader,
    SidebarGroupLabel,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton
} from '@/components/ui/sidebar'
import {Home} from "lucide-vue-next";
import AdminNavUser from "@/views/layouts/AdminNavUser.vue";
import {useAuthStore} from "@/stores/authStore";

const authStore = useAuthStore()

const items = [
    {
        name: "Declarations", children: [{title: "All", route: "admin.declarations.index", icon: Home}],
    },
    {
        name: "Settings", children: [{title: "Settings", route: "", icon: Home}]
    },
]
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <router-link :to="{'name': 'admin.dashboard'}">
                            <div class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                            </div>
                            <div class="ml-1 grid flex-1 text-left text-sm">
                                <span class="mb-0.5 truncate leading-tight font-semibold">PEKIDI</span>
                            </div>
                        </router-link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <SidebarContent>
                <SidebarGroup v-for="sidebarGroup in items" :key="sidebarGroup.name">
                    <SidebarGroupLabel>{{ sidebarGroup.name }}</SidebarGroupLabel>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in sidebarGroup.children" :key="item.title">
                                <SidebarMenuButton asChild>
                                    <router-link :to="{'name': item.route}">
                                        <component :is="item.icon" />
                                        <span>{{item.title}}</span>
                                    </router-link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>
            </SidebarContent>
        </SidebarContent>
        <SidebarFooter>
            <AdminNavUser :user="authStore.user" />
        </SidebarFooter>
    </Sidebar>
</template>

<style scoped>

</style>
