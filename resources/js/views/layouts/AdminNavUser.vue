<script setup lang="ts">
import {
    BadgeCheck,
    Bell,
    ChevronsUpDown,
    CreditCard,
    LogOut,
    Sparkles,
    Settings,
    Moon,
    Sun
} from "lucide-vue-next"

import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from "@/components/ui/avatar"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from "@/components/ui/sidebar"
import User from "@/models/user";
import {toast} from "vue-sonner";
import {useAuthStore} from "@/stores/authStore";
import {useColorMode} from "@vueuse/core";
import {useNavigation} from "@/composables/useNavigation";

const {goTo} = useNavigation()
const authStore = useAuthStore()

const props = defineProps<{
    user: User
}>()

const { isMobile } = useSidebar()
const colorMode = useColorMode()

const logout = async () => {
    const isLoggedOut: Boolean = await authStore.logout()
    if (isLoggedOut === true) {
        goTo('auth.login')
    } else {
        toast.error($t("errors.unexpected"))
    }
}

const toggleColorMode = () => {
    colorMode.value = (colorMode.value !== 'dark') ? 'dark' : 'light'
}
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="w-full text-primary-foreground/90 hover:text-primary-foreground hover:bg-accent/10 data-[state=open]:bg-accent/10 data-[state=open]:text-primary-foreground dark:text-sidebar-muted dark:hover:text-sidebar-fg dark:hover:bg-sidebar-hover-bg dark:data-[state=open]:bg-sidebar-hover-bg dark:data-[state=open]:text-sidebar-fg transition-all duration-150 rounded-default px-2"
                    >
                        <Avatar class="h-8 w-8 rounded-default border border-border/20 dark:border-sidebar-border">
                            <AvatarImage :src="user.avatar" :alt="user.name" />
                            <AvatarFallback class="rounded-default bg-accent text-accent-foreground font-semibold text-xs dark:bg-sidebar-hover-bg dark:text-sidebar-fg">
                                {{ user.name?.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) || 'US' }}
                            </AvatarFallback>
                        </Avatar>

                        <div class="grid flex-1 text-left text-sm leading-tight ml-2">
                            <span class="truncate font-sans font-semibold tracking-wide text-sm dark:text-sidebar-fg">{{ user.name }}</span>
                            <span class="truncate text-xs text-primary-foreground/60 font-medium dark:text-sidebar-muted">{{ user.email }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4 text-primary-foreground/50 shrink-0 dark:text-sidebar-muted/60" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>

                <DropdownMenuContent
                    class="w-[--reka-dropdown-menu-trigger-width] min-w-56 bg-card border border-neutral-200 text-foreground shadow-ambient rounded-default p-1.5 dark:border-border dark:shadow-none inner-glow"
                    :side="isMobile ? 'bottom' : 'right'"
                    align="end"
                    :side-offset="8"
                >
                    <DropdownMenuLabel class="p-0 font-normal mb-1">
                        <div class="flex items-center gap-2.5 px-2 py-2 text-left text-sm bg-neutral-50/60 rounded-default border border-neutral-100 dark:bg-muted/50 dark:border-border/50 inner-glow">
                            <Avatar class="h-8 w-8 rounded-default border border-neutral-200 shadow-sm dark:border-border dark:shadow-none">
                                <AvatarImage :src="user.avatar" :alt="user.name" />
                                <AvatarFallback class="rounded-default bg-neutral-100 text-neutral-600 font-semibold text-xs dark:bg-muted dark:text-muted-foreground">
                                    {{ user.name?.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) || 'US' }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-sans font-semibold text-neutral-800 dark:text-foreground">{{ user.name }}</span>
                                <span class="truncate text-xs text-muted-foreground">{{ user.email }}</span>
                            </div>
                        </div>
                    </DropdownMenuLabel>

                    <DropdownMenuSeparator class="bg-neutral-100 my-1 dark:bg-border" />

                    <DropdownMenuGroup class="space-y-0.5">
                        <DropdownMenuItem
                            @click="goTo('admin.profileSettings.userInfo')"
                            class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-600 hover:text-primary hover:bg-neutral-50 rounded-default cursor-pointer transition-all duration-150 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted/70"
                        >
                            <Settings class="h-4 w-4 shrink-0 text-neutral-400 group-hover:text-primary dark:text-muted-foreground dark:group-hover:text-foreground" />
                            <span class="font-medium">Profile Settings</span>
                        </DropdownMenuItem>

                        <DropdownMenuItem
                            @click="toggleColorMode"
                            class="flex items-center gap-2 px-2.5 py-2 text-sm text-neutral-600 hover:text-primary hover:bg-neutral-50 rounded-default cursor-pointer transition-all duration-150 dark:text-muted-foreground dark:hover:text-foreground dark:hover:bg-muted/70"
                        >
                            <Moon v-show="colorMode !== 'dark'" class="h-4 w-4 shrink-0 text-neutral-400 dark:text-muted-foreground" />
                            <Sun v-show="colorMode === 'dark'" class="h-4 w-4 shrink-0 text-neutral-400 dark:text-muted-foreground" />
                            <span class="font-medium">
                                {{ $t(colorMode !== 'dark' ? 'settings.dark_mode' : 'settings.light_mode') }}
                            </span>
                        </DropdownMenuItem>
                    </DropdownMenuGroup>

                    <DropdownMenuSeparator class="bg-neutral-100 my-1 dark:bg-border" />

                    <DropdownMenuItem
                        @click="logout"
                        class="flex items-center gap-2 px-2.5 py-2 text-sm rounded-default cursor-pointer text-neutral-600 hover:text-primary hover:bg-neutral-50 transition-all duration-150 dark:text-muted-foreground dark:hover:text-destructive dark:hover:bg-destructive/10"
                    >
                        <LogOut class="h-4 w-4 shrink-0 text-neutral-600 dark:text-muted-foreground" />
                        <span class="font-semibold">Log out</span>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
