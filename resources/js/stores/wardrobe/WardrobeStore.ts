import {defineStore} from "pinia";
import {AddClothesResponse, RemoveClothesResponse, WardrobeResponse} from "./types/responses.ts";
import axios, {AxiosResponse} from "axios";
import {Clothes} from "./types/enitities.ts";

export const useWardrobeStore = defineStore('wardrobe', {
    state: () => {
        return {
            wardrobe: [] as Clothes[],
            apiToken: null as unknown as string
        };
    },

    getters: {
        inWardrobe(state) {
            return (id: number): boolean => {
                return state.wardrobe.find((clothes: Clothes): boolean => clothes.id === id) !== undefined
            };
        },

        listRequestUrl(): string {
            return `/api/v1/wardrobe/`;
        },

        addRequestUrl(): string {
            return `/api/v1/wardrobe/add`;
        },

        removeClothesUrl(): string {
            return `/api/v1/wardrobe/remove`;
        },

        requestData: (state) => {
            return (data: unknown = {}) => {
                return Object.assign({ api_token: state.apiToken }, data);
            }
        }
    },

    actions: {
        async fetchWardrobe(): Promise<void> {
            if (!this.apiToken) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.listRequestUrl, this.requestData());
            const data: WardrobeResponse = response.data;

            if (data.success) {
                data.items.forEach((item: Clothes) => this.wardrobe.push(item));
            }
        },

        async addClothes(clothes: Clothes): Promise<void> {
            if (!this.apiToken) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.addRequestUrl, this.requestData({
                clothes_id: clothes.id
            }));
            const data: AddClothesResponse = response.data;

            if (data.success) {
                this.wardrobe.push(clothes);
            }
        },

        async removeClothes(clothes: Clothes): Promise<void> {
            if (!this.apiToken) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.removeClothesUrl, this.requestData({
                clothes_id: clothes.id
            }));
            const data: RemoveClothesResponse = response.data;

            if (data.success) {
                this.wardrobe = this.wardrobe.filter((item: Clothes): boolean => item.id !== clothes.id);
            }
        },

        setApiToken(apiToken: string): void {
            this.apiToken = apiToken;
        }
    }
});
