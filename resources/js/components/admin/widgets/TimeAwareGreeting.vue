<script setup lang="ts">
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import Heading from "@/components/Heading.vue";
import {useAuthStore} from "@/stores/authStore";

const greetingKey = computed(() => {
    const hour = new Date().getHours();
    if (hour < 12) return 'titles.good_morning_user';
    if (hour < 18) return 'titles.hello_user';
    return 'titles.greeting_evening_user';
});

const authStore = useAuthStore()
</script>

<template>
    <Heading :title="greetingKey" :titleParams="[authStore.user?.name ?? '']" />
</template>
