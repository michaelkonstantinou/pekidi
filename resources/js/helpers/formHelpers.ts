import {FormContext} from "vee-validate";
import {toast} from "vue-sonner";

/**
 * Updates the all Form's fields error messages with the validation errors received from the API (if any)
 * Process only validation errors (API status must be 422)
 *
 * @param form
 * @param apiResponseErrors
 */
export function updateFormErrors(form: FormContext, apiResponseErrors: any) {
    if (apiResponseErrors.response?.status === 422) {
        const messageErrors = apiResponseErrors.response.data.errors
        Object.keys(messageErrors).forEach((field) => {
            form.setFieldError(field, messageErrors[field][0])
        })
    }
}
