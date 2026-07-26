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

    <div class="inline-flex gap-1 rounded-default bg-muted/60 dark:bg-muted/40 p-1 border border-neutral-200/60 dark:border-border">
        <button
            v-for="{ value, Icon, label } in tabs"
            :key="value"
            @click="mode = value"
            :class="[
                'flex items-center rounded-sm px-3.5 py-1.5 text-sm font-medium transition-all duration-150',
                mode === value
                    ? 'bg-card text-foreground shadow-xs border border-neutral-200/80 dark:border-border/80'
                    : 'text-neutral-500 dark:text-muted-foreground hover:text-foreground dark:hover:text-foreground hover:bg-neutral-200/50 dark:hover:bg-muted/80',
            ]"
        >
            <component :is="Icon" class="-ml-0.5 h-4 w-4 shrink-0" />
            <span class="ml-2 font-sans">{{ label }}</span>
        </button>
    </div>
</template>
