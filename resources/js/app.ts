import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import { createI18n } from 'vue-i18n'
import en from "@/locale/en.json"
import el from "@/locale/en.json"
import {createPinia, Pinia} from "pinia";
import {useAuthStore} from "@/stores/authStore";
import router from "@/router";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import {useColorMode} from "@vueuse/core";

const i18n = createI18n({
    locale: 'ja',
    fallbackLocale: 'en',
    messages: {
        en,
        el
    }
})

const pinia: Pinia = createPinia()
const app = createApp(App).use(i18n).use(pinia).use(autoAnimatePlugin)
const authStore = useAuthStore()
useColorMode()

authStore.fetchUser().finally(() => {
    app.use(router).mount("#app")
})
