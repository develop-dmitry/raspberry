import type Clothes from "#models/Clothes.ts";

export default interface FetchWardrobeResponse {
    success: boolean,
    items: Clothes[],
    message?: string
}
