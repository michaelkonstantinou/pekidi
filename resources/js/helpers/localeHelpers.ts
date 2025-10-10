export function getLocale(): string {
    return document.querySelector("html")?.getAttribute("lang") ?? "el";
}

export function getLocaleDateString(dateObject: Date): string {
    return dateObject.toLocaleDateString(getLocale());
}

export function getLocaleDateTimeString(dateObject: Date): string {
    return dateObject.toLocaleString(getLocale());
}

export function getLocaleCurrencyString(value: number): string {
    return new Intl.NumberFormat(getLocale(), {
        style: 'currency',
        currency: 'EUR',
    }).format(value)
}

export function setHtmlLocale(locale: string): void {
    document.querySelector("html")?.setAttribute('lang', locale);
}
