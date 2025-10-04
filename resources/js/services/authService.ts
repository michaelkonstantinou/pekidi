import axios from "axios";
import User from "@/models/user";

export default class AuthService {

    /**
     * Executes a request to obtain the csrf token and makes a POST request to the login route
     *
     * @param mail
     * @param password
     */
    static async login(mail: String, password: String) {
        await AuthService.getCsrfToken();
        return axios.post("/login", {
            "email": mail,
            "password": password
        })
    }

    static async register(fullName: String, mail: String, password: String, passwordConfirmation: String) {
        return AuthService.getCsrfToken().then(() => {
            return axios.post("/register", {
                "name": fullName,
                "email": mail,
                "password": password,
                "password_confirmation": passwordConfirmation
            })
        });
    }

    static async resetPassword(mail: String, password: String, passwordConfirmation: String, token: String) {
        return AuthService.getCsrfToken().then(() => {
            return axios.post("/reset-password", {
                "email": mail,
                "password": password,
                "password_confirmation": passwordConfirmation,
                "token": token
            })
        });
    }

    static async requestPasswordReset(mail: String): Promise<any> {
        await AuthService.getCsrfToken()
        return axios.post("/forgot-password", {"email": mail})
    }

    /**
     * Uses the API to fetch the authenticated user (if authenticated)
     * Returns null if no user is authenticated
     */
    static async getUser(): Promise<User | null> {
        try {
            const res = await axios.get("api/user")
            return new User(res.data)
        } catch (err) {
            console.error(err)
            return null
        }
    }

    /**
     * Executes a logout request for the current user
     * Returns true if the request was successful
     */
    static async logout(): Promise<boolean> {
        try {
            await axios.post("logout")
            return true
        } catch (e) {
            return false
        }
    }

    /**
     * Executes a PUT request to Fortify's update password route.
     * NOTE: The user must be logged in for this request to work
     *
     * @param currentPassword
     * @param newPassword
     * @param confirmPassword
     */
    static async userUpdatePassword(currentPassword: String, newPassword: String, confirmPassword: String) {
        return axios.put("/user/password", {
            "current_password": currentPassword,
            "password": newPassword,
            "password_confirmation": confirmPassword
        })
    }

    /**
     * Executes a PUT request to Fortify's update password route.
     * NOTE: The user must be logged in for this request to work
     */
    static async userProfileInformationUpdate(newName: String, email: String) {
        return axios.put("/user/profile-information", {
            "name": newName,
            "email": email,
        })
    }

    public static async getCsrfToken() {
        return axios.get('sanctum/csrf-cookie')
    }
}
