import axios from "axios";

export default class ApiLocaleService {
    static async updateLocaleSession(locale: String): Promise<boolean> {
        try {
            await axios.post('/switch-language/' + locale)

            return true
        } catch (error) {
            throw error
        }
    }
}
