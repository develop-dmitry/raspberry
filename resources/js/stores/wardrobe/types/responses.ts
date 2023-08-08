import {Clothes} from "./enitities.ts";

export interface WardrobeOffersResponse {
    offers: Array<Clothes>,
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

export interface WardrobeResponse {
    success: boolean,
    items: Clothes[]
}
