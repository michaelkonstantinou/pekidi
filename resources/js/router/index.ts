import {createRouter, createWebHistory, Router} from "vue-router";
import routes from "@/router/routes";
import {useAuthStore} from "@/stores/authStore";

const router: Router = createRouter({
    history: createWebHistory(),
    routes: routes,
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()
    if (to.meta.requiresAuth === true && !authStore.isAuthenticated()) {
        next({"name": "auth.login"})
    }

    next()
})

export default router
