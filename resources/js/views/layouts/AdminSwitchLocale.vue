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

import {Globe, Check} from "lucide-vue-next";
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
            <Button
                variant="ghost"
                size="icon"
                class="h-9 w-9 rounded-default text-neutral-500 hover:text-neutral-800 hover:bg-neutral-100 transition-colors duration-150"
            >
                <Globe class="h-4 w-4 shrink-0" />
                <span class="sr-only">Switch language</span>
            </Button>
        </DropdownMenuTrigger>

        <!-- Dropdown Canvas Popover -->
        <DropdownMenuContent
            class="min-w-[150px] bg-card border border-neutral-200/80 p-1 rounded-default shadow-md"
            align="end"
            :side-offset="8"
        >
            <div class="space-y-0.5">
                <!-- English Selection Action (Swapped to standard DropdownMenuItem) -->
                <DropdownMenuItem
                    @click="locale = 'en'"
                    class="relative flex items-center justify-between w-full px-3 py-2 text-sm rounded-default cursor-pointer hover:bg-neutral-50 transition-colors"
                    :class="locale === 'en' ? 'text-neutral-900 font-semibold bg-neutral-200/50' : 'text-neutral-600'"
                >
                    <!-- Left: Icon + Label group -->
                    <div class="flex items-center gap-2.5">
                        <img
                            src="https://flagsapi.com/GB/flat/24.png"
                            alt="United Kingdom Flag"
                            class="w-4 h-4 object-contain shrink-0"
                        />
                        <span class="font-sans">English</span>
                    </div>

                    <!-- Right: Clear trailing check icon -->
                    <Check v-if="locale === 'en'" class="h-3.5 w-3.5 text-neutral-800 shrink-0 ml-2" />
                </DropdownMenuItem>

                <!-- Greek Selection Action (Swapped to standard DropdownMenuItem) -->
                <DropdownMenuItem
                    @click="locale = 'el'"
                    class="relative flex items-center justify-between w-full px-3 py-2 text-sm rounded-default cursor-pointer hover:bg-neutral-50 transition-colors"
                    :class="locale === 'el' ? 'text-neutral-900 font-semibold bg-neutral-200/50' : 'text-neutral-600'"
                >
                    <!-- Left: Icon + Label group -->
                    <div class="flex items-center gap-2.5">
                        <img
                            src="https://flagsapi.com/GR/flat/24.png"
                            alt="Greece Flag"
                            class="w-4 h-4 object-contain shrink-0"
                        />
                        <span class="font-sans">Ελληνικά</span>
                    </div>

                    <!-- Right: Clear trailing check icon -->
                    <Check v-if="locale === 'el'" class="h-3.5 w-3.5 text-neutral-800 shrink-0 ml-2" />
                </DropdownMenuItem>
            </div>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
