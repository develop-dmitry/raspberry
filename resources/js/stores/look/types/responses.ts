import {Look} from "./enitites.ts";

export interface DetailLookResponse {
    success: boolean,
    look: Look
}

export interface HowFitResponse {
    success: boolean,
    how_fit: number,
    message?: string
}
