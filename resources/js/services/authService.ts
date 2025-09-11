import axios from "axios";
import User from "@/models/user";

export default class AuthService {

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

    private static async getCsrfToken() {
        return axios.get('sanctum/csrf-cookie')
    }
}
