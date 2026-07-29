import {TranslationFunction, ViewRecordRow} from "@/types";
import {FormFieldItem} from "@/dataTypes";
import {TypedSchema} from "vee-validate";
import {toTypedSchema} from "@vee-validate/zod";
import * as z from "zod";

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

    /**
     * Generates a VeeValidate-compatible Zod schema for form validation.
     *
     * Provides a default empty schema (`z.object({})`). Subclasses should override this
     * method to define field-level validation rules synchronized with backend FormRequests.
     *
     * Try to always override this function when you have fields, to make sure that the validation
     * is smooth and user-friendly. It is the only reason we support two validation methods after all
     *
     * @param t - The translation function (e.g., `vue-i18n`'s `t` or `$t`) used to resolve error messages dynamically with parameter interpolation.
     * @returns A `TypedSchema` ready for consumption by VeeValidate's `useForm` hook.
     */
    static getFormValidationSchema(t: TranslationFunction): TypedSchema {
        return toTypedSchema(z.object({}));
    }
}
