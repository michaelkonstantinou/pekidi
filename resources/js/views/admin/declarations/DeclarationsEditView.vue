<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import {BreadcrumbItemType} from "@/types";
import Heading from "@/components/Heading.vue";
import { Separator } from '@/components/ui/separator';
import {Button} from "@/components/ui/button";
import {useRoute, useRouter} from "vue-router";
import {useDeclarationStore} from "@/stores/declarationStore";
import {computed, onMounted, Ref, ref} from "vue";
import Declaration from "@/models/declaration";

const declarationStore = useDeclarationStore()
const route = useRoute()
const declarationId = route.params.id
const declaration = ref<Declaration | null>()
const isLoading: Ref<boolean> = ref<boolean>(true);

onMounted(async () => {
    declaration.value = await declarationStore.fetchById(declarationId)
    isLoading.value = false
})

const breadcrumbs = computed(() => [
    {'label': 'Dashboard', routeName: 'admin.dashboard'},
    {'label': 'Declarations', routeName: 'admin.declarations.index'},
    {'label': declaration.value?.name ?? '', routeName: ''}
])

</script>

<template>
<AdminLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 py-6">
        <Heading title="declarations.title_edit" :titleParams="[declaration?.name ?? '']" description="settings.description"/>

        <Separator class="my-6" />
        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            { 'bg-muted': true },
                        ]"
                        as-child
                    >
                        <span>Personal Details</span>
                    </Button>
                    <Button
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            // { 'bg-muted': urlIsActive(item.href, currentPath) },
                        ]"
                        as-child
                    >
                        <span>Family Details</span>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    Content
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
