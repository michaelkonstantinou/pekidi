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
import DeclarationPersonalDetailsEditor
    from "@/components/admin/declarations/editor/DeclarationPersonalDetailsEditor.vue";
import DeclarationFamilyDetailsEditor from "@/components/admin/declarations/editor/DeclarationFamilyDetailsEditor.vue";

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


const tabs = ref([
    {'label': 'declarations.personal_details', isActive: true, content: DeclarationPersonalDetailsEditor},
    {'label': 'declarations.family_details', isActive: false, content: DeclarationFamilyDetailsEditor}
])
const activeTab = computed(() => tabs.value.find(tab => tab.isActive))

function navigateToTab(index: number): void {
    tabs.value.forEach(item => item.isActive = false)
    tabs.value[index].isActive = true
}

/**
 * Refresh the Declaration values of the page when a form is saved
 * NOTE: We don't use isLoading here because the forms are already updated. This would have caused unnecessary overhead
 */
async function onSaved() {
    declaration.value = await declarationStore.fetchById(declarationId)
}
</script>

<template>
<AdminLayout :breadcrumbs="breadcrumbs">
    <div class="px-4 py-6">
        <Heading
            title="declarations.title_edit"
             :titleParams="[declaration?.name ?? '']"
             description="declarations.description_edit"
        />

        <Separator class="my-6" />
        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button
                        v-for="(tab, index) in tabs"
                        :key="tab.label"
                        class="cursor-pointer"
                        variant="ghost"
                        :class="[
                            'w-full justify-start',
                            { 'bg-primary/10 text-primary': tab.isActive },
                        ]"
                        as-child
                        @click="navigateToTab(index)"
                    >
                        <span>{{ $t(tab.label) }}</span>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl" v-if="declaration !== null && !isLoading">
                <section class="max-w-2xl space-y-12">
                    <component :is="activeTab.content" :declaration="declaration" @saved="onSaved"/>
                </section>
            </div>
        </div>
    </div>

</AdminLayout>
</template>
