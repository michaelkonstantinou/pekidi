import {toast} from "vue-sonner";
import {useI18n} from "vue-i18n";

export function useErrorMessager() {
    const { t } = useI18n()

    /**
     * Handles an API error and shows a toast if needed
     * @param errors - the Axios or Fetch error object
     */
    function toastApiErrors(errors: any) {
        const code = errors?.response?.status

        switch (code) {
            case 401:
                toast.error(t("errors.unauthorized"))
                break
            case 403:
                toast.error(t("errors.forbidden"))
                break
            case 500:
                toast.error(t("errors.server"))
                break
            default:
                if (code !== 422 && code >= 400) {
                    toast.error(t("errors.unexpected"))
                }
        }
    }

    return { toastApiErrors }
}
