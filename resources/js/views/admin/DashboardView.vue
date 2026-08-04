<script setup lang="ts">
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import { BreadcrumbItemType } from "@/types";
import ContinueDeclarationCard from "@/components/admin/widgets/ContinueDeclarationCard.vue";
import { onMounted, Ref, ref } from "vue";
import Declaration from "@/models/declaration";
import UserDeclarationService from "@/services/userDeclarationService";
import { useRouter } from "vue-router";
import CreateDeclarationWidget from "@/components/admin/widgets/CreateDeclarationWidget.vue";

const breadcrumbs: BreadcrumbItemType[] = [
    { 'label': 'Dashboard', routeName: 'admin.dashboard' }
];
const service = new UserDeclarationService();
const router = useRouter();
const lastDeclaration: Ref<Declaration | null> = ref(null);

onMounted(async () => {
    lastDeclaration.value = await service.findLast();
});

function continueLastDeclaration() {
    if (lastDeclaration.value === null) {
        return;
    }

    router.push({ 'name': 'admin.declarations.edit', 'params': { 'id': lastDeclaration.value.id } });
}

function navigateToAllDeclarations() {
    router.push({ 'name': 'admin.declarations.index' })
}
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <!-- Full-Width Card (Animates on async data resolve) -->
            <Transition
                enter-active-class="transition-all duration-700 ease-out"
                enter-from-class="opacity-0 translate-y-6 scale-[0.98]"
                enter-to-class="opacity-100 translate-y-0 scale-100"
            >
                <div v-if="lastDeclaration" key="continue-card">
                    <ContinueDeclarationCard
                        :declaration="lastDeclaration"
                        @continue="continueLastDeclaration"
                    />
                </div>
            </Transition>

            <!-- Grid Row below (Animates on initial page load) -->
            <TransitionGroup
                appear
                tag="div"
                class="grid grid-cols-1 gap-6 md:grid-cols-2"
                enter-active-class="transition-all duration-700 ease-out"
                enter-from-class="opacity-0 translate-y-6 scale-[0.98]"
                enter-to-class="opacity-100 translate-y-0 scale-100"
            >
                <!-- Component 2: Takes half width (1 of 2 columns) -->
                <div key="create-widget" class="col-span-1 transition-all duration-700 delay-100">
                    <CreateDeclarationWidget @create="navigateToAllDeclarations" />
                </div>

                <!-- Future Half-Width Widget goes here -->
                <div key="future-widget" class="col-span-1 transition-all duration-700 delay-200">
                    <!-- Widget 3 Slot -->
                </div>
            </TransitionGroup>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
