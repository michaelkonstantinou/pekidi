import axios from "axios";

export default abstract class ApiResourceRepository<TModel> {
    protected abstract routePrefix: string
    protected abstract model: new (data: any) => TModel

    async all(): Promise<TModel[] | null> {
        try {
            const { data } = await axios.get(this.routePrefix)
            return data.map((item: any) => new this.model(item))
        } catch (error) {
            return null
        }
    }

    async create(recordValues: any): Promise<TModel | null> {
        try {
            const { data } = await axios.post(this.routePrefix, recordValues)

            return new this.model(data)
        } catch (error) {
            throw error
        }
    }

    async update(recordValues: any): Promise<TModel | null> {
        try {
            const { data } = await axios.patch(this.routePrefix + "/" + recordValues.id, recordValues)

            return new this.model(data)
        } catch (error) {
            throw error
        }
    }

    async deleteById(id: any): Promise<boolean> {
        try {
            const { data } = await axios.post(this.routePrefix + "/" + id, {_method: "DELETE"})

            return true
        } catch (error) {
            throw error
        }
    }

    async findById(id: any): Promise<TModel | null> {
        try {
            const { data } = await axios.get(this.routePrefix + "/" + id)

            return new this.model(data)
        } catch (error) {
            return null
        }
    }
}
