export interface WardrobeOffer {
    id: number,
    name: string,
    photo: string
}

export interface WardrobeOffersResponse {
    offers: Array<WardrobeOffer>,
    success: boolean,
    count: number,
    page: number,
    total: number
}

export interface AddClothesResponse {
    success: boolean,
    message: string
}

export interface RemoveClothesResponse {
    success: boolean,
    message: string
}
