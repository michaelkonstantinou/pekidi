import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import { createI18n } from 'vue-i18n'
import en from "@/locale/en.json"
import el from "@/locale/en.json"
import {createPinia} from "pinia";

const i18n = createI18n({
    locale: 'ja',
    fallbackLocale: 'en',
    messages: {
        en,
        el
    }
})

const pinia = createPinia()
const app = createApp(App).use(i18n).use(pinia)
app.mount("#app")
// const authStore = useAuthStore()
// authStore.fetchUser().finally(() => {
//     app.use(router).mount("#app")
// })
