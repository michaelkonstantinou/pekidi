export default class User{
    id: number
    email: string
    name: string
    createdAt: Date
    updatedAt: Date

    constructor(data: any) {
        this.id = data.id
        this.email = data.email
        this.name = data.name
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
    }
}
