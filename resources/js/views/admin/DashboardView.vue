<script setup lang="ts">

import {Button} from "@/components/ui/button";
import {useAuthStore} from "@/stores/authStore";
import {useRouter} from "vue-router";
import {toast} from "vue-sonner";
import AdminLayout from "@/views/layouts/AdminLayout.vue";

const authStore = useAuthStore()
const router = useRouter()

const logout = async () => {
    const isLoggedOut: Boolean = await authStore.logout()
    if (isLoggedOut === true) {
        router.push({'name': 'auth.login'})
    } else {
        toast.error($t("errors.unexpected"))
    }
}
</script>

<template>
<AdminLayout>
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
        <h1>Hey you are logged in!</h1>
        <Button @click="logout">Logout</Button>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="aspect-video rounded-xl bg-muted/50" />
            <div class="aspect-video rounded-xl bg-muted/50" />
            <div class="aspect-video rounded-xl bg-muted/50" />
        </div>
        <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" />
    </div>

</AdminLayout>
</template>

<style scoped>

</style>
