import {defineStore} from "pinia";
import {ref, Ref} from "vue";
import User from "@/models/user";
import AuthService from "@/services/authService";

export const useAuthStore = defineStore('auth', () => {
    const user: Ref<User | null> = ref(null)

    function isAuthenticated() {
        return user.value !== null
    }

    function getUserName(): string {
        return user.value?.name ?? "Guest"
    }

    async function fetchUser() {
        user.value = await AuthService.getUser()
    }

    async function logout() {
        return AuthService.logout()
            .then(() => {
                user.value = null
                return true
            }).catch(() => false)
    }

    return { user, isAuthenticated, logout, fetchUser, getUserName }
})
