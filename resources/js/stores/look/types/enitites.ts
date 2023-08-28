export interface Look {
    id: number,
    name: string,
    slug: string,
    photo: string,
    description: string,
    clothes: Clothes[],
    events: Event[]
}

export interface Clothes {
    id: number,
    photo: string,
    name: string
}

export interface Event {
    name: string
}

export interface User {
    id: number
}
