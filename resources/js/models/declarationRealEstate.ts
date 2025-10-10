import {ViewRecordRow} from "@/types";
import {getLocaleDateString, getLocaleDateTimeString} from "@/helpers/localeHelpers";

export default class DeclarationRealEstate {
    id: number
    location: string
    realEstateType: string
    area: number
    acquisitionType: string
    acquisitionYear: number
    acquisitionValue: number
    currentValue: number
    rightsEncumbrances: string
    createdAt: Date
    updatedAt: Date
    declarationId: number
    owner: string

    constructor(data: any) {
        this.id = data.id
        this.location = data.location
        this.area = data.area
        this.realEstateType = data.real_estate_type
        this.acquisitionType = data.acquisition_type
        this.acquisitionYear = data.acquisition_year
        this.acquisitionValue = data.acquisition_value
        this.currentValue = data.current_value
        this.rightsEncumbrances = data.rights_encumbrances
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
        this.declarationId = data.declaration_id
        this.owner = data.owner
    }

    toViewRecordData(): ViewRecordRow[] {
        return [
            {label: "labels.location", value: this.location, isLongText: false},
            {label: "labels.real_estate_type", value: this.realEstateType, isLongText: false},
            {label: "labels.area", value: this.area.toString(), isLongText: false},
            {label: "labels.acquisition_type", value: this.acquisitionType, isLongText: false},
            {label: "labels.acquisition_year", value: this.acquisitionYear.toString(), isLongText: false},
            {label: "labels.acquisition_value", value: this.acquisitionValue.toString(), isLongText: false},
            {label: "labels.current_value", value: this.currentValue.toString(), isLongText: false},
            {label: "labels.rights_encumbrances", value: this.rightsEncumbrances, isLongText: true},
            {label: "labels.created_at", value: getLocaleDateTimeString(this.createdAt), isLongText: false},
            {label: "labels.updated_at", value: getLocaleDateTimeString(this.updatedAt), isLongText: false},
        ]
    }
}
