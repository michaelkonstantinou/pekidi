export default class DeclarationFamilyMember {
    id: number
    fullName: string
    profession: string
    nationalId: string
    createdAt: Date
    updatedAt: Date
    bornAt: Date | null

    constructor(data: any) {
        this.id = data.id
        this.fullName = data.full_name
        this.nationalId = data.national_id
        this.profession = data.profession
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
