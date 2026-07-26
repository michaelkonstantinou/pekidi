<script setup lang="ts">
import { Button } from "@/components/ui/button"
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import {Linkedin} from "lucide-vue-next";
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
import {ref, Ref} from "vue";
import {useI18n} from "vue-i18n";
import {FormFieldItem} from "@/dataTypes";
import AuthLayout from "@/views/layouts/AuthLayout.vue";
import AuthSubmitButton from "@/components/auth-ui/AuthSubmitButton.vue";
const router = useRouter()
const form = useForm()
const { t } = useI18n()
const mailSent: Ref<boolean> = ref(false)
const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("email", "E-mail", "email", "my.name@example.com")
]

const onSubmit = form.handleSubmit(async (values) => {
    isLoading.value = true
    try {
        await AuthService.requestPasswordReset(values.email)
        mailSent.value = true
        toast.success(t("messages.auth.reset_request_successful"))
    } catch (errors: any) {
        mailSent.value = false
        if (errors.response?.status === 422) {
            const messageErrors = errors.response.data.errors
            Object.keys(messageErrors).forEach((field) => {
                form.setFieldError(field, messageErrors[field][0])
            })
        }
    } finally {
        isLoading.value = false
    }
})


</script>

<template>
    <AuthLayout title="forgot_password_title" description="forgot_password_description">
        <form @submit.prevent="onSubmit">
            <div class="grid gap-6">
                <div>
                    <FormField
                        v-for="field in formFields"
                        v-slot="{ componentField }"
                        :key="field.name"
                        :name="field.name"
                    >
                        <FormItem v-auto-animate class="space-y-1.5 text-left">
                            <FormLabel class="text-sm font-medium text-neutral-700 dark:text-foreground">
                                {{ field.label }}
                            </FormLabel>

                            <FormControl>
                                <div class="relative">
                                    <!-- Dynamic Icon Support -->
                                    <component
                                        v-if="field.icon"
                                        :is="field.icon"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 dark:text-muted-foreground h-4 w-4 pointer-events-none"
                                    />
                                    <Input
                                        :type="field.type"
                                        :placeholder="field.placeholder"
                                        v-bind="componentField"
                                        class="h-11 border-neutral-300 dark:border-border dark:bg-muted/30 dark:text-foreground dark:placeholder:text-muted-foreground rounded-default transition-all duration-150 outline-none focus-visible:outline-none focus:border-primary focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20"
                                        :class="field.icon ? 'pl-9 pr-3' : 'px-3'"
                                    />
                                </div>
                            </FormControl>

                            <FormMessage class="text-xs text-destructive mt-1" />
                        </FormItem>
                    </FormField>

                    <!-- Mail Sent Success / Info Alert Callout -->
                    <div
                        v-show="mailSent"
                        class="mt-4 p-3 rounded-default bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-center text-sm font-medium text-emerald-700 dark:text-emerald-300 transition-colors"
                    >
                        {{ $t("reset_password_link_sent") }}
                    </div>
                </div>

                <!-- Submit Action Button -->
                <AuthSubmitButton title="auth.change_password" />

                <!-- Navigation Switch Link Footer -->
                <div class="mt-brand-md text-center">
                    <p class="text-sm text-neutral-500 dark:text-muted-foreground">
                        {{ $t("auth.dont_have_account") }}
                        <router-link :to="{ name: 'auth.register' }" class="text-secondary dark:text-primary font-semibold hover:underline decoration-2 ml-1">
                            {{ $t("auth.sign_up") }}
                        </router-link>
                    </p>
                </div>
            </div>
        </form>
    </AuthLayout>
</template>
