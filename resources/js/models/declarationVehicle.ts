import {ViewRecordRow} from "@/types";
import {getLocaleCurrencyString, getLocaleDateString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationVehicle {
    id: number
    description: string
    value: number
    createdAt: Date
    updatedAt: Date
    declarationId: number
    owner: string

    constructor(data: any) {
        this.id = data.id
        this.declarationId = data.declaration_id
        this.owner = data.owner
        this.description = data.description
        this.value = data.value
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
    }

    toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.description", value: this.description, isLongText: false, isMeta: false},
            {label: "labels.value", value: getLocaleCurrencyString(this.value), isLongText: false, isMeta: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false, isMeta: true},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false, isMeta: true},
        ]
    }
}
