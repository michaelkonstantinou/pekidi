import axios from 'axios';
import {useAuthStore} from "@/stores/authStore.js";
import router from "@/router/index.js";
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = import.meta.env.VITE_URL

/**
 * The following interceptor will check if a response is rejected due to Token Expire (e.g. timeout for auth user)
 * If the (authenticated) user's session is expired, then it will log him out from the authentication store
 * and navigate the user to the login page
 */
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        // Catch Laravel session timeouts (419 Page Expired)
        if (error.response && (error.response.status === 419)) {

            const authStore = useAuthStore()
            authStore.user = null

            // 2. Force redirect to login page
            router.push({ name: "auth.login" });

            // Optional: Prevent the error from bubbling further if you want to silence it
            return new Promise(() => {});
        }

        return Promise.reject(error);
    }
);
