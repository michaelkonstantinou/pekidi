import {ViewRecordRow} from "@/types";
import {getLocaleDateString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationFamilyMember {
    id: number
    fullName: string
    profession: string
    nationalId: string
    relationship: string
    createdAt: Date
    updatedAt: Date
    bornAt: Date | null
    declarationId: number

    constructor(data: any) {
        this.id = data.id
        this.declarationId = data.declaration_id
        this.fullName = data.full_name
        this.nationalId = data.national_id
        this.profession = data.profession
        this.relationship = data.relationship
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
        this.bornAt = data.born_at !== null ? new Date(data.born_at) : null
    }

    toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.national_id", value: this.nationalId, isLongText: false},
            {label: "labels.full_name", value: this.fullName, isLongText: false},
            {label: "labels.relationship", value: this.relationship, isLongText: false},
            {label: "labels.profession", value: this.profession, isLongText: false},
            {label: "labels.born_at", value: this.bornAt !== null ? getLocaleDateString(this.bornAt) : '', isLongText: false},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false},
        ]
    }

    getBornAtAsInputString(): String | null {
        if (this.bornAt === null) {
            return null
        }

        return this.bornAt.toISOString().split('T')[0]
    }
}
