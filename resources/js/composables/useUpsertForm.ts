import {FormContext} from "vee-validate";
import ApiResourceRepository from "@/services/apiResourceRepository";
import {type Ref, ref} from "vue";
import {toast} from "vue-sonner";
import {useI18n} from "vue-i18n";
import {updateFormErrors} from "@/helpers/formHelpers";
import {useErrorMessager} from "@/composables/useErrorMessager";

export function useUpsertForm<T>(form: FormContext,
                                 apiService: ApiResourceRepository<T>,
                                 record: any = null,
                                 onSuccess: () => void,
                                 successMessage = "messages.actions.save_success",
                                 ) {
    const isFormLoading: Ref<Boolean> = ref(false)
    const {t} = useI18n()
    const {toastApiErrors} = useErrorMessager()

    /**
     * Handles the submission of a form that can be used to either create a new instance or update an existing one
     * It provides information such as when the form is loading, updates the form error messages and informs the user
     * on successful submission
     */
    const onSubmit = form.handleSubmit(async (values: any) => {
        isFormLoading.value = true
        createOrUpdate(apiService, record, values).then(() => {
            toast.success(t(successMessage))
            form.resetForm()
            onSuccess()
        }).catch(errors => {
            updateFormErrors(form, errors)
            toastApiErrors(errors)
        }).finally(() => isFormLoading.value = false)
    })

    /**
     * Depending on whether a record to update exists, the function will either submit a create request or an update one
     *
     * @param service
     * @param record
     * @param values
     */
    async function createOrUpdate(service: ApiResourceRepository<T>, record: any, values: any) {
        if (record !== null) {
            values.id = record.id
            return await service.update(values)
        }

        return await service.create(values)
    }

    return {onSubmit, isFormLoading}
}
