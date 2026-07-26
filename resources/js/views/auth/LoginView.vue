<script setup lang="ts">
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import AuthService from "@/services/authService";
import {ref, Ref} from "vue";
import {useRouter} from "vue-router";
import {useAuthStore} from "@/stores/authStore";
import {toast} from "vue-sonner";
import {useDeclarationStore} from "@/stores/declarationStore";
import AuthLayout from "@/views/layouts/AuthLayout.vue";
import AuthSubmitButton from "@/components/auth-ui/AuthSubmitButton.vue";
import {Mail, Lock} from "lucide-vue-next";
import AuthFormInput from "@/components/auth-ui/AuthFormInput.vue";

const authStore = useAuthStore()
const declarationStore = useDeclarationStore()
const router = useRouter()

// Variables
const email: Ref<String> = ref("")
const password: Ref<String> = ref("")

async function onSubmit() {
    try {
        await AuthService.login(email.value, password.value)
        await authStore.fetchUser()
        await declarationStore.fetchAll()
        await router.push({ name: "admin.dashboard" })
    } catch (error: any) {
        if (error.response && error.response.status === 422) {
            toast.error("Incorrect credentials")
        } else {
            toast.error("Something went wrong. Please try again in a while")
        }
    }
}

</script>

<template>
    <AuthLayout title="login_title" description="login_description">
        <form @submit.prevent="onSubmit" class="space-y-4">

            <!-- SSO Identity Provider Blocks -->
            <div class="flex flex-col gap-3">
                <Button type="button" variant="outline" class="w-full h-11 flex items-center justify-center gap-2 border-neutral-300 hover:bg-neutral-50 dark:border-border dark:bg-card dark:hover:bg-muted/60 dark:text-foreground transition-colors rounded-default">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="#0077B5"></circle><path fill-rule="evenodd" clip-rule="evenodd" d="M18.7747 14.2839C18.7747 15.529 17.8267 16.5366 16.3442 16.5366C14.9194 16.5366 13.9713 15.529 14.0007 14.2839C13.9713 12.9783 14.9193 12 16.3726 12C17.8267 12 18.7463 12.9783 18.7747 14.2839ZM14.1199 32.8191V18.3162H18.6271V32.8181H14.1199V32.8191Z" fill="white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M22.2393 22.9446C22.2393 21.1357 22.1797 19.5935 22.1201 18.3182H26.0351L26.2432 20.305H26.3322C26.9254 19.3854 28.4079 17.9927 30.8101 17.9927C33.7752 17.9927 35.9995 19.9502 35.9995 24.219V32.821H31.4922V24.7838C31.4922 22.9144 30.8404 21.6399 29.2093 21.6399C27.9633 21.6399 27.2224 22.4999 26.9263 23.3297C26.8071 23.6268 26.7484 24.0412 26.7484 24.4574V32.821H22.2411V22.9446H22.2393Z" fill="white"></path></svg>
                    <span>{{ $t("auth.login_with_linkedin") }}</span>
                </Button>
                <Button type="button" variant="outline" class="w-full h-11 flex items-center justify-center gap-2 border-neutral-300 hover:bg-neutral-50 dark:border-border dark:bg-card dark:hover:bg-muted/60 dark:text-foreground transition-colors rounded-default">
                    <svg class="h-5 w-5 shrink-0" viewBox="-3 0 262 262" version="1.1" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid"><g><path d="M255.878,133.451 C255.878,122.717 255.007,114.884 253.122,106.761 L130.55,106.761 L130.55,155.209 L202.497,155.209 C201.047,167.249 193.214,185.381 175.807,197.565 L175.563,199.187 L214.318,229.21 L217.003,229.478 C241.662,206.704 255.878,173.196 255.878,133.451" fill="#4285F4"></path><path d="M130.55,261.1 C165.798,261.1 195.389,249.495 217.003,229.478 L175.807,197.565 C164.783,205.253 149.987,210.62 130.55,210.62 C96.027,210.62 66.726,187.847 56.281,156.37 L54.75,156.5 L14.452,187.687 L13.925,189.152 C35.393,231.798 79.49,261.1 130.55,261.1" fill="#34A853"></path><path d="M56.281,156.37 C53.525,148.247 51.93,139.543 51.93,130.55 C51.93,121.556 53.525,112.853 56.136,104.73 L56.063,103 L15.26,71.312 L13.925,71.947 C5.077,89.644 0,109.517 0,130.55 C0,151.583 5.077,171.455 13.925,189.152 L56.281,156.37" fill="#FBBC05"></path><path d="M130.55,50.479 C155.064,50.479 171.6,61.068 181.029,69.917 L217.873,33.943 C195.245,12.91 165.798,0 130.55,0 C79.49,0 35.393,29.301 13.925,71.947 L56.136,104.73 C66.726,73.253 96.027,50.479 130.55,50.479" fill="#EB4335"></path></g></svg>
                    <span>{{ $t("auth.login_with_google") }}</span>
                </Button>
            </div>

            <!-- Context Separator -->
            <div class="relative text-center text-sm py-2 after:absolute after:inset-0 after:top-1/2 after:z-0 after:flex after:items-center after:border-t after:border-neutral-200 dark:after:border-border">
              <span class="relative z-10 bg-card px-3 text-muted-foreground font-medium">
                Or continue with
              </span>
            </div>

            <!-- Credentials Input Blocks -->
            <div class="space-y-4">

                <!-- Email -->
                <AuthFormInput
                    v-model="email"
                    id="email"
                    label="Email Address"
                    type="email"
                    placeholder="myname@example.com"
                    :icon="Mail"
                />

                <!-- Password Field -->
                <AuthFormInput
                    v-model="password"
                    id="password"
                    label="Password"
                    type="password"
                    placeholder="********"
                    :icon="Lock"
                >
                    <template #action>
                        <router-link
                            :to="{'name': 'auth.forgotPassword'}"
                            class="text-xs font-semibold text-secondary dark:text-primary hover:underline underline-offset-2"
                        >
                            {{ $t("auth.forgot_your_password") }}
                        </router-link>
                    </template>
                </AuthFormInput>
            </div>

            <!-- Action Submit Form Button -->
            <AuthSubmitButton title="auth.login" />
        </form>

        <!-- Navigation Switch Link Footer -->
        <div class="mt-brand-md text-center">
            <p class="text-sm text-neutral-500 dark:text-muted-foreground">
                {{ $t("auth.dont_have_account") }}
                <router-link
                    :to="{'name': 'auth.register'}"
                    class="text-secondary dark:text-primary font-semibold hover:underline decoration-2 ml-1"
                >
                    {{ $t("auth.sign_up") }}
                </router-link>
            </p>
        </div>
    </AuthLayout>
</template>
