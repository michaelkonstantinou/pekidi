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
import {useRoute, useRouter} from "vue-router";
import {toast} from "vue-sonner";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form'
import {useForm} from "vee-validate";
import {useI18n} from "vue-i18n";
import {FormFieldItem} from "@/dataTypes";
const router = useRouter()
const form = useForm()
const route = useRoute()
const {t} = useI18n()

const token: String = route.query["token"]?.toString() ?? ""

const formFields: FormFieldItem[] = [
    {name: "email", label: "E-mail", type: "email", placeholder: "my.name@example.com"},
    {name: "password", label: "New password", type: "password", placeholder: ""},
    {name: "passwordConfirmation", label: "Confirm password", type: "password", placeholder: ""}
]

const onSubmit = form.handleSubmit((values) => {
    AuthService.resetPassword(values.email, values.password, values.passwordConfirmation, token)
        .then(() => {
            toast.success(t("messages.auth.successful_reset"))
            router.push({ name: "auth.login" })
        })
        .catch(errors => {
            if (errors.response?.status === 422) {
                const messageErrors = errors.response.data.errors
                // 4. Feed backend errors into vee-validate
                Object.keys(messageErrors).forEach((field) => {
                    form.setFieldError(field, messageErrors[field][0])
                })
            }
        })

});

</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-6">
            <div class="flex flex-col gap-6">
                <Card>
                    <CardHeader class="text-center">
                        <CardTitle class="text-xl">
                            {{ $t("auth.reset_title") }}
                        </CardTitle>
                        <CardDescription>
                            {{ $t("auth.reset_description") }}
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="onSubmit">
                            <div class="grid gap-6">
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
                                <Button type="submit" class="w-full">
                                    {{ $t("auth.change_password") }}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </div>
</template>
