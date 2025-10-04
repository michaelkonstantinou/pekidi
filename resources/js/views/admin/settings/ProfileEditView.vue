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
import {ref, Ref, useTemplateRef} from "vue";
import {useAuthStore} from "@/stores/authStore";

// Import FilePond
import vueFilePond, {setOptions} from 'vue-filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';

setOptions({
    server: {
        process: {
            url: "/api/user/upload-profile-picture",
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        }
    },
});

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImageEdit, FilePondPluginImagePreview, FilePondPluginImageResize, FilePondPluginImageCrop, FilePondPluginImageTransform);
const elUserProfilePicture = useTemplateRef('user-profile-picture')
const authStore = useAuthStore()
const form: FormContext = useForm({
    "initialValues": {
        name: authStore.user?.name,
        email: authStore.user?.email
    },
})
const {t} = useI18n()
const isLoading: Ref<boolean> = ref(false)

const formFields: FormFieldItem[] = [
    new FormFieldItem("name", "Name"),
    new FormFieldItem("email", "E-mail", "email"),
]

const onSubmit = form.handleSubmit(values => {
    isLoading.value = true
    AuthService.userProfileInformationUpdate(values.name, values.email)
        .then(async () => {
            toast.success(t("messages.auth.update_user_profile_success"))
            await authStore.fetchUser()
            form.resetForm({
                values: {
                    "name": authStore.user?.name,
                    "email": authStore.user?.email
                },
                errors: {}
            })
        }).catch(errors => {
            updateFormErrors(form, errors)
        }).finally(() => isLoading.value = false)
})

</script>

<template>
    <HeadingSmall title="settings.update_profile" description="settings.update_profile_description" />
    <div class="flex justify-center">
            <FilePond
                class="w-100"
                name="image"
                ref="user-profile-picture"
                label-idle="Set profile picture..."
                allow-multiple="false"
                accepted-file-types="image/jpeg, image/png"
                max-file-size="1MB"
                style-panel-layout="compact circle"
                styleLoadIndicatorPosition="center bottom"
                styleProgressIndicatorPosition="right bottom"
                styleButtonRemoveItemPosition="center bottom"
                :allowImagePreview="true"
                :imagePreviewHeight="150"
                imageCropAspectRatio="1:1"
                :imageResizeTargetWidth="150"
                :imageResizeTargetHeight="150"
            />
    </div>
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
        <Button type="submit" class="mt-5" :disabled="isLoading">
            {{ $t("auth.update_profile") }}
        </Button>
    </form>
</template>


