<script setup lang="ts">

import {Button} from "@/components/ui/button";
import {useAuthStore} from "@/stores/authStore";
import {useRouter} from "vue-router";
import {toast} from "vue-sonner";

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
<h1>Hey you are logged in!</h1>
    <Button @click="logout">Logout</Button>
</template>

<style scoped>

</style>
