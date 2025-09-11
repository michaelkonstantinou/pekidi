<script setup lang="ts">
import {FormContext, useForm} from "vee-validate";
import {FormFieldItem} from "@/dataTypes";
import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";
import HeadingSmall from "@/components/HeadingSmall.vue";
import {updateFormErrors} from "@/helpers/formHelpers";
import AuthService from "@/services/authService";
import {toast} from "vue-sonner";
import {useI18n} from "vue-i18n";
import {ref, Ref} from "vue";
const form: FormContext = useForm()
const {t} = useI18n()
const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("current_password", "Current password", "password"),
    new FormFieldItem("password", "New password", "password"),
    new FormFieldItem("password_confirmation", "Confirm password", "password")
]

const onSubmit = form.handleSubmit(values => {
    isLoading.value = true
    AuthService.userUpdatePassword(values.current_password, values.password, values.password_confirmation)
        .then(() => {
            toast.success(t("messages.auth.update_password_success"))
            form.resetForm()
        }).catch(errors => {
            updateFormErrors(form, errors)
        }).finally(() => isLoading.value = false)
})
</script>

<template>
    <HeadingSmall title="settings.update_pass_title" description="settings.update_pass_description" />
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

        </div>
        <Button type="submit" class="mt-3" :disabled="isLoading">
            {{ $t("auth.change_password") }}
        </Button>
    </form>
</template>
