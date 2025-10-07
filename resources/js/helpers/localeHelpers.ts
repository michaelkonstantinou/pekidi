export function getLocale(): string {
    return document.querySelector("html")?.getAttribute("lang") ?? "el";
}

export function getLocaleDateString(dateObject: Date): string {
    return dateObject.toLocaleDateString(getLocale());
}

export function getLocaleDateTimeString(dateObject: Date): string {
    return dateObject.toLocaleString(getLocale());
}

export function setHtmlLocale(locale: string): void {
    document.querySelector("html")?.setAttribute('lang', locale);
}
