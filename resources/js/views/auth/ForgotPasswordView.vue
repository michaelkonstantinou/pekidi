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
                        :name="field.name">
                        <FormItem v-auto-animate>
                            <FormLabel>{{ field.label }}</FormLabel>
                            <FormControl>
                                <Input :type="field.type" :placeholder="field.placeholder" v-bind="componentField" class="h-11 border-neutral-300 rounded-default focus-visible:ring-secondary"/>
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <div v-show="mailSent" class="text-center text-sm mt-2 text-red-600">
                        {{ $t("reset_password_link_sent")}}
                    </div>
                </div>

                <AuthSubmitButton title="auth.change_password" />
                <div class="mt-brand-md text-center">
                    <p class="text-sm text-neutral-500">
                        {{ $t("auth.dont_have_account") }}
                        <router-link :to="{ name: 'auth.register' }" class="text-secondary font-semibold hover:underline decoration-2 ml-1">
                            {{ $t("auth.sign_up") }}
                        </router-link>
                    </p>
                </div>
            </div>
        </form>
    </AuthLayout>
</template>
