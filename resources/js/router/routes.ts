import {useAuthStore} from "@/stores/authStore";

const redirectIfAuthenticated = async (to, from, next) => {
    const authStore = useAuthStore()
    if (authStore.isAuthenticated()) {
        next({name: "admin.dashboard"})
    }

    next()
}

const routes = [
    {
        path: "/login",
        name: "auth.login",
        component: () => import("@/views/auth/LoginView.vue"),
        beforeEnter: redirectIfAuthenticated,
    },
    {
        path: "/register",
        name: "auth.register",
        component: () => import("@/views/auth/RegisterView.vue"),
        beforeEnter: redirectIfAuthenticated,
    },
    {
        path: "/forgot-password",
        name: "auth.forgotPassword",
        component: () => import("@/views/auth/ForgotPasswordView.vue"),
        beforeEnter: redirectIfAuthenticated,
    },
    {
        path: "/reset-password",
        name: "auth.resetPassword",
        component: () => import("@/views/auth/RegisterView.vue"),
    },
    {
        path: "/admin",
        meta: {requiresAuth: true},
        children: [
            {
                path: "dashboard",
                name: "admin.dashboard",
                component: () => import("@/views/admin/DashboardView.vue"),
            }
        ]
    }
]

export default routes
