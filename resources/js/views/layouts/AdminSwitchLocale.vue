<script lang="ts" setup>
import {ref, watch} from "vue"
import { Button } from "@/components/ui/button"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuRadioGroup,
    DropdownMenuRadioItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"

import {Globe} from "lucide-vue-next";
import ApiLocaleService from "@/services/apiLocaleService";
import {useI18n} from "vue-i18n";
import {toast} from "vue-sonner";
import {setHtmlLocale} from "@/helpers/localeHelpers";

const {t, locale} = useI18n()
function switchLanguage(lang: string) {
    ApiLocaleService.updateLocaleSession(lang)
        .then(() => {
            locale.value = lang
            setHtmlLocale(lang)
        })
        .catch(() => toast.error(t('errors.unexpected')));
}

watch(locale, (newValue) => switchLanguage(newValue))
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="outline" size="icon">
                <Globe />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56">
            <DropdownMenuRadioGroup v-model="locale">
                <DropdownMenuRadioItem value="en">
                    <img src="https://flagsapi.com/GB/shiny/24.png" alt="">
                    <span>English</span>
                </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="el">
                    <img src="https://flagsapi.com/GR/shiny/24.png" alt="">
                    <span>Ελληνικά</span>
                </DropdownMenuRadioItem>
            </DropdownMenuRadioGroup>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
