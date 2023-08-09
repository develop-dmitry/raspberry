export interface Look {
    id: number,
    name: string,
    slug: string,
    photo: string,
    description: string,
    clothes: Clothes[]
}

export interface Clothes {
    id: number,
    photo: string,
    name: string
}
