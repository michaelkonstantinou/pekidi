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
import DeclarationPersonalAssetsEditor
    from "@/components/admin/declarations/editor/DeclarationPersonalAssetsEditor.vue";
import {CloudLightning, FileText, LoaderPinwheel} from "lucide-vue-next";

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
    {'label': 'declarations.spouse_assets', isActive: false, content: DeclarationPersonalAssetsEditor, owner: 'spouse'}
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
                        class="text-neutral-800"
                    />
                </div>
            </div>

            <div class="flex flex-col md:flex-row min-w-0 gap-6 w-full items-start">

                <aside class="w-full md:w-64 shrink-0">
                    <nav class="flex flex-col space-y-1">
                        <Button
                            v-for="(tab, index) in tabs"
                            :key="tab.label"
                            variant="ghost"
                            :class="[
                                'w-full justify-start gap-3 px-4 py-2.5 h-auto font-medium text-sm rounded-default transition-all duration-150 cursor-pointer',
                                tab.isActive
                                  ? 'bg-primary text-primary-foreground font-semibold shadow-sm hover:bg-primary hover:text-primary-foreground'
                                  : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-200/50 focus:bg-neutral-200/50'
                            ]"
                            @click="navigateToTab(index)"
                        >
                            <component
                                :is="tab.icon || FileText"
                                class="h-4 w-4 shrink-0"
                                :class="tab.isActive ? 'text-current' : 'text-neutral-400'"
                            />
                            <span>{{ $t(tab.label) }}</span>
                        </Button>
                    </nav>
                </aside>

                <!-- Right Side Expanded Full-Width Form Card Frame -->
                <!-- 2. Keep min-w-0 here and add overflow-x-hidden to prevent layout spillover -->
                <div class="flex-1 w-full min-w-0 bg-white rounded-default border border-neutral-200/60 shadow-sm min-h-[600px] overflow-hidden">
                    <div class="p-6 md:p-8 w-full min-w-0" v-if="declaration !== null && !isLoading">
                        <!-- 3. Add min-w-0 here so the rendering canvas lets the table shrink -->
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
                        <LoaderPinwheel class="h-8 w-8 text-neutral-400 animate-spin mb-2" />
                        <p class="text-xs text-neutral-400 font-medium font-sans">Loading data registry forms...</p>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
