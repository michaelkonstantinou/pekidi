export function getLocale(): string {
    return document.querySelector("html")?.getAttribute("lang") ?? "el-GR";
}

export function getLocaleDateString(dateObject: Date): string {
    return dateObject.toLocaleDateString(getLocale());
}

export function getLocaleDateTimeString(dateObject: Date): string {
    return dateObject.toLocaleString(getLocale());
}
