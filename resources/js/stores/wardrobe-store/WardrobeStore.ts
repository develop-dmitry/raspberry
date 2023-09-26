import {defineStore} from "pinia";
import Clothes from "#models/Clothes.ts";
import {AxiosResponse} from "axios";
import axios from "axios";
import type AddClothesResponse from "#stores/wardrobe-store/responses/AddClothesResponse.ts";
import type AddClothesRequest from "#stores/wardrobe-store/requests/AddClothesRequest.ts";
import type RemoveClothesResponse from "#stores/wardrobe-store/responses/RemoveClothesResponse.ts";
import type RemoveClothesRequest from "#stores/wardrobe-store/requests/RemoveClothesRequest.ts";
import type FetchWardrobeResponse from "#stores/wardrobe-store/responses/FetchWardrobeResponse.ts";
import type FetchOffersRequest from "#stores/wardrobe-store/requests/FetchOffersRequest.ts";
import type FetchOffersResponse from "#stores/wardrobe-store/responses/FetchOffersResponse.ts";

export const useWardrobeStore = defineStore('wardrobe', {
    state() {
        return {
            clothes: [] as Clothes[]
        };
    },

    getters: {
        inWardrobe(state) {
            return (id: number): boolean => {
                return state.clothes.find((clothes: Clothes): boolean => clothes.id === id) !== undefined;
            };
        }
    },

    actions: {
        setClothes(clothes: Clothes[]): void {
            this.clothes = clothes;
        },

        async addClothes(request: AddClothesRequest): Promise<boolean> {
            const response: AxiosResponse = await axios.post('/api/v1/wardrobe/add', request);
            const data: AddClothesResponse = response.data;

            return data.success;
        },

        async removeClothes(request: RemoveClothesRequest): Promise<boolean> {
            const response: AxiosResponse = await axios.post('/api/v1/wardrobe/remove', request);
            const data: RemoveClothesResponse = response.data;

            return data.success;
        },

        async fetchWardrobe(): Promise<Clothes[]> {
            const response: AxiosResponse = await axios.post('/api/v1/wardrobe');
            const data: FetchWardrobeResponse = response.data;

            if (!data.success) {
                throw new Error(data.message);
            }

            return data.items;
        },

        async fetchOffers(request: FetchOffersRequest): Promise<FetchOffersResponse> {
            const response: AxiosResponse = await axios.post('/api/v1/wardrobe/offers', request);
            const data: FetchOffersResponse = response.data;

            if (!data.success) {
                throw new Error(data.message);
            }

            return data;
        }
    }
});
