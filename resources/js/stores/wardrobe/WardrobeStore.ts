import {defineStore} from "pinia";
import {AddClothesResponse, RemoveClothesResponse, WardrobeResponse} from "./types/responses.ts";
import axios, {AxiosResponse} from "axios";
import {Clothes, User} from "./types/enitities.ts";

export const useWardrobeStore = defineStore('wardrobe', {
    state: () => {
        return {
            wardrobe: [] as Clothes[],
            user: null as unknown as User
        };
    },

    getters: {
        inWardrobe: (state) => {
            return (id: number): boolean => {
                return state.wardrobe.find((clothes: Clothes): boolean => clothes.id === id) !== undefined
            };
        },

        listRequestUrl(): string {
            return `/api/v1/wardrobe/${this.user.id}`;
        },

        addRequestUrl(): string {
            return `/api/v1/wardrobe/${this.user.id}/add`;
        },

        removeClothesUrl(): string {
            return `/api/v1/wardrobe/${this.user.id}/remove`;
        }
    },

    actions: {
        async fetchWardrobe(): Promise<void> {
            if (!this.user) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.listRequestUrl);
            const data: WardrobeResponse = response.data;

            if (data.success) {
                data.items.forEach((item: Clothes) => this.wardrobe.push(item));
            }
        },

        async addClothes(clothes: Clothes): Promise<void> {
            if (!this.user) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.addRequestUrl, { clothes_id: clothes.id });
            const data: AddClothesResponse = response.data;

            if (data.success) {
                this.wardrobe.push(clothes);
            }
        },

        async removeClothes(clothes: Clothes): Promise<void> {
            if (!this.user) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.removeClothesUrl, { clothes_id: clothes.id});
            const data: RemoveClothesResponse = response.data;

            if (data.success) {
                this.wardrobe = this.wardrobe.filter((item: Clothes): boolean => item.id !== clothes.id);
            }
        },

        setUser(user: User): void {
            this.user = user;
        }
    }
});
