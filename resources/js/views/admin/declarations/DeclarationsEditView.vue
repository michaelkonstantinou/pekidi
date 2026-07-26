<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import Heading from "@/components/Heading.vue";
import { Separator } from '@/components/ui/separator';
import {useRoute, useRouter} from "vue-router";
import {useDeclarationStore} from "@/stores/declarationStore";
import {computed, onMounted, Ref, ref} from "vue";
import Declaration from "@/models/declaration";
import DeclarationPersonalDetailsEditor
    from "@/components/admin/declarations/editor/DeclarationPersonalDetailsEditor.vue";
import DeclarationFamilyDetailsEditor from "@/components/admin/declarations/editor/DeclarationFamilyDetailsEditor.vue";
import DeclarationPersonalAssetsEditor
    from "@/components/admin/declarations/editor/DeclarationPersonalAssetsEditor.vue";
import {FileText, LoaderPinwheel} from "lucide-vue-next";
import AppVerticalTab from "@/components/app-ui/AppVerticalTab.vue";
import DeclarationOverview from "@/components/admin/declarations/DeclarationOverview.vue";

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
    {'label': 'declarations.family_details', isActive: false, content: DeclarationFamilyDetailsEditor},
    {'label': 'declarations.personal_assets', isActive: false, content: DeclarationPersonalAssetsEditor, owner: 'self'},
    {'label': 'declarations.spouse_assets', isActive: false, content: DeclarationPersonalAssetsEditor, owner: 'spouse'},
    {'label': 'declarations.children_assets', isActive: false, content: DeclarationPersonalAssetsEditor, owner: 'child'},
    {'label': 'declarations.overview', isActive: false, content: DeclarationOverview},
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
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <Heading
                        title="declarations.title_edit"
                        :titleParams="[declaration?.name ?? '']"
                        description="declarations.description_edit"
                    />
                </div>
            </div>

            <div class="flex flex-col md:flex-row min-w-0 gap-6 w-full items-start">

                <aside class="py-6 md:py-8 w-full md:w-56 shrink-0 min-w-0">
                    <nav class="flex flex-col space-y-1">
                        <AppVerticalTab
                            v-for="(tab, index) in tabs.slice(0, -1)"
                            :key="tab.label"
                            :icon="tab.icon || FileText"
                            :active="tab.isActive"
                            :label="tab.label"
                            @click="navigateToTab(index)"
                        />
                        <Separator class="my-4" />

                        <AppVerticalTab
                            v-if="tabs.length"
                            :key="tabs[tabs.length - 1].label"
                            :icon="tabs[tabs.length - 1].icon || FileText"
                            :active="tabs[tabs.length - 1].isActive"
                            :label="tabs[tabs.length - 1].label"
                            @click="navigateToTab(tabs.length - 1)"
                        />
                    </nav>
                </aside>

                <!-- Right Side Expanded Full-Width Form Card Frame -->
                <div class="flex-1 w-full min-w-0 bg-white dark:bg-card rounded-default border border-neutral-200/60 dark:border-border shadow-sm dark:shadow-none min-h-[600px] overflow-hidden transition-colors duration-150">
                    <div class="p-6 md:p-8 w-full min-w-0" v-if="declaration !== null && !isLoading">
                        <section class="w-full h-full min-w-0 overflow-x-hidden">
                            <component
                                :key="activeTab.label"
                                :is="activeTab.content"
                                :declaration="declaration"
                                :owner="activeTab?.owner"
                                @saved="onSaved"
                            />
                        </section>
                    </div>

                    <!-- Loading Fallback Skeleton Layer State -->
                    <div v-else class="min-h-[600px] flex flex-col items-center justify-center p-12 text-center w-full">
                        <LoaderPinwheel class="h-8 w-8 text-neutral-400 dark:text-muted-foreground animate-spin mb-2" />
                        <p class="text-xs text-neutral-400 dark:text-muted-foreground font-medium font-sans">Loading data registry forms...</p>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
