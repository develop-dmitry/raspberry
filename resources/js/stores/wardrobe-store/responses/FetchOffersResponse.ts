import type Clothes from "#models/Clothes.ts";

export default interface FetchOffersResponse {
    success: boolean,
    page: number,
    count: number,
    total: number,
    items: Clothes[],
    message?: string
}
