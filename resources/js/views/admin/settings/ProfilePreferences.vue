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
import {Monitor, Moon, Sun} from "lucide-vue-next";
import {useColorMode} from "@vueuse/core";
const form: FormContext = useForm()
const {t} = useI18n()
const mode = useColorMode()

const tabs = [
    { value: 'light', Icon: Sun, label: 'Light' },
    { value: 'dark', Icon: Moon, label: 'Dark' },
    { value: 'system', Icon: Monitor, label: 'System' },
]
</script>

<template>
    <HeadingSmall title="settings.preferences_title" description="settings.preferences_description" />

    <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800">
        <button
            v-for="{ value, Icon, label } in tabs"
            :key="value"
            @click="mode = value"
            :class="[
                'flex items-center rounded-md px-3.5 py-1.5 transition-colors',
                mode === value
                    ? 'bg-white shadow-xs dark:bg-neutral-700 dark:text-neutral-100'
                    : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
            ]"
        >
            <component :is="Icon" class="-ml-1 h-4 w-4" />
            <span class="ml-1.5 text-sm">{{ label }}</span>
        </button>
    </div>
</template>
