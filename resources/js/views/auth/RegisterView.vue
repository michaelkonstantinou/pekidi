<script setup lang="ts">
import { Button } from "@/components/ui/button"
import { User, Mail, Lock, RefreshCw, Eye, EyeOff } from "lucide-vue-next"

// Make sure to define them so your component tree can see them dynamically
const components = {
    User,
    Mail,
    Lock,
    RefreshCw,
    Eye,
    EyeOff
}
import { Input } from "@/components/ui/input"
import AuthService from "@/services/authService";
import {useRouter} from "vue-router";
import {toast} from "vue-sonner";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form'
import {useForm} from "vee-validate";
import {FormFieldItem} from "@/dataTypes";
import AuthLayout from "@/views/layouts/AuthLayout.vue";
import AuthSubmitButton from "@/components/auth-ui/AuthSubmitButton.vue";
import {computed, ref} from "vue";
const router = useRouter()
const form = useForm()

const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "Full name", "text", "John Smith"),
    new FormFieldItem("email", "E-mail", "email", "my.name@example.com"),
    new FormFieldItem("password", "Password", "password"),
    new FormFieldItem("passwordConfirmation", "Confirm password", "password")
]

const onSubmit = form.handleSubmit((values) => {
    AuthService.register(values.name, values.email, values.password, values.passwordConfirmation)
        .then(() => {
            toast.success($t("messages.auth.successful_registration"))
            router.push({ name: "auth.login" })
        })
        .catch(errors => {
            if (errors.response?.status === 422) {
                const messageErrors = errors.response.data.errors
                Object.keys(messageErrors).forEach((field) => {
                    form.setFieldError(field, messageErrors[field][0])
                })
            }
        })
});

const showPassword = ref(false)

// Dynamic Password Strength Calculation connected to Form state values
const passwordStrength = computed(() => {
    // Read directly from the vee-validate form state
    const val = form.values.password
    let score = 0

    if (!val) return { score: 0, text: "Weak", colorClass: "bg-destructive", textClass: "text-destructive" }

    if (val.length > 5) score++
    if (val.length > 8) score++
    if (/[A-Z]/.test(val)) score++
    if (/[0-9]/.test(val)) score++
    if (/[^A-Za-z0-9]/.test(val)) score++

    if (score <= 2) {
        return { score, text: "Weak", colorClass: "bg-destructive", textClass: "text-destructive" }
    } else if (score <= 4) {
        return { score, text: "Moderate", colorClass: "bg-secondary/60", textClass: "text-destructive/60" }
    } else {
        return { score, text: "Secure", colorClass: "bg-secondary", textClass: "text-primary font-semibold" }
    }
})

</script>

<template>
    <AuthLayout title="register_title" description="register_description">
        <form @submit.prevent="onSubmit">
            <div class="grid gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <FormField
                        v-for="field in formFields"
                        v-slot="{ componentField }"
                        :key="field.name"
                        :name="field.name"
                    >
                        <FormItem v-auto-animate class="space-y-1.5 text-left col-span-1 md:col-span-2">
                            <FormLabel class="text-sm font-medium text-neutral-700 dark:text-foreground">
                                {{ field.label }}
                            </FormLabel>

                            <FormControl>
                                <div class="relative">
                                    <!-- Leading Field Icon -->
                                    <component
                                        v-if="field.icon"
                                        :is="field.icon"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 dark:text-muted-foreground h-4 w-4 pointer-events-none"
                                    />

                                    <Input
                                        :type="field.name === 'password' && showPassword ? 'text' : field.type"
                                        :placeholder="field.placeholder"
                                        v-bind="componentField"
                                        class="h-11 border-neutral-300 dark:border-border dark:bg-muted/30 dark:text-foreground dark:placeholder:text-muted-foreground rounded-default transition-all duration-150 outline-none focus-visible:outline-none focus:border-primary focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20"
                                        :class="field.icon ? 'pl-9 pr-10' : 'px-3'"
                                    />

                                    <!-- Password Visibility Toggle Button Overlay -->
                                    <button
                                        v-if="field.name === 'password'"
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 dark:text-muted-foreground hover:text-neutral-700 dark:hover:text-foreground transition-colors focus:outline-none cursor-pointer"
                                    >
                                        <component :is="showPassword ? EyeOff : Eye" class="h-4 w-4" />
                                    </button>
                                </div>
                            </FormControl>

                            <!-- Password Strength Indicator -->
                            <div class="pt-1.5 space-y-1" v-if="field.name === 'password' && form.values.password">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-medium" :class="passwordStrength.textClass">
                                        Security Strength: {{ passwordStrength.text }}
                                    </span>
                                </div>
                                <div class="w-full bg-neutral-200 dark:bg-muted/80 rounded-full h-1 overflow-hidden">
                                    <div
                                        class="h-full transition-all duration-300 ease-in-out"
                                        :class="passwordStrength.colorClass"
                                        :style="{ width: `${Math.min(passwordStrength.score * 20, 100)}%` }"
                                    ></div>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-muted-foreground" v-if="passwordStrength.score < 5">
                                    Hint: Try mixing special characters, numbers, lowercase and uppercase letters
                                </p>
                            </div>

                            <FormMessage class="text-xs text-destructive mt-1" />
                        </FormItem>
                    </FormField>
                </div>

                <!-- Action Form Submission Button -->
                <AuthSubmitButton title="auth.sign_up" />

                <!-- Login Switch Footer -->
                <div class="mt-brand-md text-center">
                    <p class="text-sm text-neutral-500 dark:text-muted-foreground">
                        {{ $t("auth.have_account") }}
                        <router-link :to="{ name: 'auth.login' }" class="text-secondary dark:text-primary font-semibold hover:underline decoration-2 ml-1">
                            {{ $t("auth.login") }}
                        </router-link>
                    </p>
                </div>
            </div>
        </form>
    </AuthLayout>
</template>
