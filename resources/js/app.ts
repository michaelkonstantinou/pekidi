import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import { createI18n } from 'vue-i18n'
import en from "@/locale/en.json"
import el from "@/locale/el.json"
import {createPinia, Pinia} from "pinia";
import {useAuthStore} from "@/stores/authStore";
import router from "@/router";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import {useColorMode} from "@vueuse/core";
import {useDeclarationStore} from "@/stores/declarationStore";
import {getLocale} from "@/helpers/localeHelpers";
import {configure} from "vee-validate";
import { z } from 'zod'; // 1. Import Zod

export const i18n = createI18n({
    locale: getLocale(),
    fallbackLocale: 'en',
    availableLocales: ['en', 'el'],
    messages: {
        en,
        el
    }
});

z.setErrorMap((issue, ctx) => {
    return { message: i18n.global.t(issue.message || "validation." + ctx.defaultError.toLowerCase()) };
});

const pinia: Pinia = createPinia()
const app = createApp(App).use(i18n).use(pinia).use(autoAnimatePlugin)
const authStore = useAuthStore()
const declarationStore = useDeclarationStore()
useColorMode()

authStore.fetchUser()
    .then(() => declarationStore.fetchAll())
    .finally(() => {
        app.use(router).mount("#app")
    })
