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
import {BookText, Home, Settings} from "lucide-vue-next";
import AdminNavUser from "@/views/layouts/AdminNavUser.vue";
import {useAuthStore} from "@/stores/authStore";
import {useDeclarationStore} from "@/stores/declarationStore";

const authStore = useAuthStore()
const declarationStore = useDeclarationStore()

const items = [
    {
        name: "Declarations", children: [{title: "All", route: "admin.declarations.index", icon: BookText, routeParams: {}}],
    },
    {
        name: "Settings", children: [{title: "Settings", route: "admin.profileSettings", icon: Settings, routeParams: {}}]
    },
]

// Append Declarations
for (const declaration of declarationStore.declarations) {
    items[0].children.push(
        {
            title: declaration.name,
            route: "admin.declarations.edit",
            routeParams: {'id': declaration.id},
            icon: null
        })
}
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
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton asChild>
                            <router-link :to="{'name': 'admin.dashboard'}">
                                <component :is="Home" />
                                <span>Dashboard</span>
                            </router-link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
                <SidebarGroup v-for="sidebarGroup in items" :key="sidebarGroup.name">
                    <SidebarGroupLabel>{{ sidebarGroup.name }}</SidebarGroupLabel>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in sidebarGroup.children" :key="item.title">
                                <SidebarMenuButton asChild>
                                    <router-link
                                        active-class="bg-primary text-primary-foreground hover:bg-primary/90"
                                        :to="{'name': item.route, 'params': item.routeParams}">
                                        <component v-if="item.icon !== null" :is="item.icon" />
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
