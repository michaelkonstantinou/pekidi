<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import {BreadcrumbItemType} from "@/types";
import Heading from "@/components/Heading.vue";
import { Separator } from '@/components/ui/separator';
import {Button} from "@/components/ui/button";

const breadcrumbs: BreadcrumbItemType[] = [
    {'label': 'Dashboard', routeName: 'admin.dashboard'},
    {'label': 'settings.title', routeName: ''}
]

const settingsRoutes = [
    {name: 'admin.profileSettings.userInfo', label: 'Profile'},
    {name: 'admin.profileSettings.updatePassword', label: 'Password'},
    {name: 'admin.profileSettings.preferences', label: 'Preferences'}
]
</script>

<template>
<AdminLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 py-6">
        <Heading title="settings.title" description="settings.description"/>

        <Separator class="my-6" />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <template v-for="settingsRoute in settingsRoutes"
                              :key="settingsRoute.name">
                        <router-link
                            :to="{ name: settingsRoute.name }"
                            custom
                            v-slot="{ href, navigate, isActive }"
                        >
                            <Button
                                variant="ghost"
                                as="a"
                                :href="href"
                                :class="[
                              'w-full justify-start',
                              { 'bg-primary/10 text-primary': isActive } // 👈 active styles
                            ]"
                                @click="navigate"
                            >
                                {{ settingsRoute.label }}
                            </Button>
                        </router-link>
                    </template>


                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <router-view />
                </section>
            </div>
        </div>
    </div>

</AdminLayout>
</template>

<style scoped>
button:has(a.router-link-active) {
    background-color: #3490dc; /* for example */
    color: white;
}

</style>
