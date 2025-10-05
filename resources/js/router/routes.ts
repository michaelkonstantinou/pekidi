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
        component: () => import("@/views/auth/ResetPasswordView.vue"),
        beforeEnter: redirectIfAuthenticated,
    },
    {
        path: "/admin",
        meta: {requiresAuth: true},
        children: [
            {
                path: "dashboard",
                name: "admin.dashboard",
                component: () => import("@/views/admin/DashboardView.vue"),
            },
            {
                path: "declarations",
                name: "admin.declarations.index",
                component: () => import("@/views/admin/declarations/DeclarationsIndexView.vue"),
            },
            {
                path: "declarations/:id/edit",
                name: "admin.declarations.edit",
                component: () => import("@/views/admin/declarations/DeclarationsEditView.vue"),
            },
            {
                path: "profile-settings",
                name: "admin.profileSettings",
                component: () => import("@/views/admin/ProfileSettingsView.vue"),
                redirect: { name: "admin.profileSettings.userInfo" },
                children: [
                    {
                        path: "user-info",
                        name: "admin.profileSettings.userInfo",
                        component: () => import("@/views/admin/settings/ProfileEditView.vue"),
                    },
                    {
                        path: "update-password",
                        name: "admin.profileSettings.updatePassword",
                        component: () => import("@/views/admin/settings/ProfileUpdatePasswordView.vue"),
                    },
                    {
                        path: "preferences",
                        name: "admin.profileSettings.preferences",
                        component: () => import("@/views/admin/settings/ProfilePreferences.vue"),
                    }
                ]
            }
        ]
    }
]

export default routes
