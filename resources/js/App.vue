<script setup>
import 'vue-sonner/style.css'
import { Toaster } from '@/components/ui/sonner'
</script>

<template>
    <Toaster position="top-center" richColors/>
    <router-view></router-view>
</template>

<style scoped>

</style>
