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
    <Sidebar collapsible="icon" variant="none" class="w-64 border-r border-none bg-primary text-primary-foreground">
        <!-- Sidebar Branding Header Section -->
        <SidebarHeader class="p-6 pb-10">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="hover:bg-transparent p-0 m-0 h-auto">
                        <router-link :to="{'name': 'admin.dashboard'}" class="flex items-center gap-2">
                            <img
                                class="w-10 h-10 object-contain shrink-0"
                                alt="Official gold-embossed Republic of Cyprus Coat of Arms"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSLxoe-Lj8DZY62bOFosJVdl4zLwjUSmP_DUN3_qCaXrDZLQg5ze94iEAzMZREO7De6-rhKjratyO_614iX9haU1pk5UhvYhUs0lJXguJogwyi9ZAO_3YWA89h8Mox2TQLsGoYidE6wkuPmoHsNgTzCW1OfUFme3XGzuqGQc2TFzCxqYjmoedSLuQQn9A8GWY8rNFCW6APohu9VmSOuAhKZQs4zqpi2RtwMUUo98amgNbZashqy_nAcOFH42Xtj6lSkpuOXtb-U1Q"
                            />
                            <div class="grid flex-1 text-left leading-tight">
                                <h1 class="text-primary-foreground font-bold text-[20px] font-sans tracking-tight leading-tight">Asset Management</h1>
                                <p class="text-muted-foreground/70 text-xs font-sans mt-0.5">Republic of Cyprus</p>
                            </div>
                        </router-link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <!-- Dynamic Main Links Content Area Navigation Grid -->
        <SidebarContent class="px-3 py-0 flex-1 space-y-0.5">
            <!-- Root Base Dashboard Link -->
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton asChild class="h-auto p-0 m-0 rounded-default bg-transparent hover:bg-transparent">
                        <router-link
                            :to="{'name': 'admin.dashboard'}"
                            active-class="bg-white/15 text-white font-semibold shadow-sm"
                            class="flex items-center w-full py-2.5 px-3 text-white/70 hover:text-white hover:bg-white/10 rounded-default transition-all duration-150 gap-3"
                        >
                            <component :is="Home" class="h-4 w-4 shrink-0" />
                            <span class="text-[14px] tracking-wide font-sans">Dashboard</span>
                        </router-link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>

            <!-- Loop Group Navigation Array Context -->
            <div v-for="sidebarGroup in items" :key="sidebarGroup.name" class="space-y-0.5 pt-2">
                <!-- Group Label Layer -->
                <div class="px-3 pb-1 text-[11px] font-bold text-white/40 uppercase tracking-widest font-sans">
                    {{ sidebarGroup.name }}
                </div>

                <SidebarMenu class="space-y-0.5">
                    <SidebarMenuItem v-for="item in sidebarGroup.children" :key="item.title">
                        <SidebarMenuButton asChild class="h-auto p-0 m-0 rounded-default bg-transparent hover:bg-transparent">
                            <router-link
                                active-class="bg-white/15 text-white font-semibold shadow-sm"
                                :to="{'name': item.route, 'params': item.routeParams}"
                                class="flex items-center w-full py-2.5 px-3 text-white/70 hover:text-white hover:bg-white/10 rounded-default transition-all duration-150 gap-3"
                            >
                                <component v-if="item.icon !== null" :is="item.icon" class="h-4 w-4 shrink-0" />
                                <span class="text-[14px] tracking-wide font-sans">{{ item.title }}</span>
                            </router-link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </div>
        </SidebarContent>

        <!-- Preserved User Layout Footer Component -->
        <SidebarFooter class="p-4 mt-auto border-t border-border/20 bg-black/10">
            <AdminNavUser :user="authStore.user" />
        </SidebarFooter>
    </Sidebar>
</template>
