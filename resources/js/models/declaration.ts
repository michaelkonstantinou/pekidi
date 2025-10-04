export default class Declaration {
    id: number
    name: string
    fullName: string
    nationalId: string | null
    homeAddress: string | null
    createdAt: Date
    updatedAt: Date
    bornAt: Date | null

    constructor(data: any) {
        this.id = data.id
        this.name = data.name
        this.fullName = data.full_name
        this.nationalId = data.national_id
        this.homeAddress = data.home_address
        this.createdAt = new Date(data.created_at)
        this.updatedAt = new Date(data.updated_at)
        this.bornAt = data.born_at !== null ? new Date(data.born_at) : null
    }

    getBornAtAsInputString(): String | null {
        if (this.bornAt === null) {
            return null
        }

        return this.bornAt.toISOString().split('T')[0]
    }
}
