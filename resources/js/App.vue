<script setup>
import 'vue-sonner/style.css'
import { Toaster } from '@/components/ui/sonner'

// Import filepond styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css';
</script>

<template>
    <Toaster position="top-center" richColors/>
    <router-view></router-view>
</template>
