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
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-6">
            <div class="flex flex-col gap-6">
                <Card>
                    <CardHeader class="text-center">
                        <CardTitle class="text-xl">
                            {{ $t("auth.forgot_password_title") }}
                        </CardTitle>
                        <CardDescription>
                            {{ $t("auth.forgot_password_description") }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
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
                                                <Input :type="field.type" :placeholder="field.placeholder" v-bind="componentField" />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    </FormField>
                                    <div v-show="mailSent" class="text-center text-sm mt-2 text-red-600">
                                        {{ $t("reset_password_link_sent")}}
                                    </div>
                                </div>

                                <Button type="submit" class="w-full" :disabled="isLoading">
                                    {{ $t("auth.change_password") }}
                                </Button>

                                <div class="text-center text-sm">
                                    {{ $t("auth.dont_have_account") }}
                                    <router-link :to="{'name': 'auth.login'}" class="underline underline-offset-4">
                                        {{ $t("auth.login") }}
                                    </router-link>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
