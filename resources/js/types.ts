export interface BreadcrumbItemType {
    label: string
    routeName: string
}

export interface ViewRecordRow {
    label: string,
    value: string,
    isLongText: boolean,
    isMeta: boolean,
}

export interface HelpContent {
    main: string,
    tip: string | null
}
