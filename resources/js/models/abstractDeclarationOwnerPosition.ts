import {ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";

export abstract class AbstractDeclarationOwnerPosition {
    id: number
    declarationId: number
    owner: string
    createdAt: Date
    updatedAt: Date

    protected constructor(data: any) {
        this.id = data.id
        this.declarationId = data.declaration_id
        this.owner = data.owner
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
    }

    /**
     * Returns the data that will appear in a View Dialog
     */
    abstract toViewRecordData(): ViewRecordRow[]

    /**
     * The function is used to initialize a form with the values from this object
     * It should return an object of this structure: {'form_field': this.objectValue }
     */
    abstract toFormValues(): Object

    /**
     * Returns the FormFieldItems that are used to design a form.
     * It needs to be a valid FormFieldItem, which contains the necessary information
     * to construct a form with all its input elements
     */
    static getFormFieldItems(): FormFieldItem[] {
        throw new Error('getFormFieldItems must be implemented by subclass')
    }
}
