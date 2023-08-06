import {defineStore} from "pinia";
import {WardrobeOffersResponse} from "../../types/responses.ts";
import axios, {AxiosResponse} from "axios";
import {Clothes, User} from "../../types/enitities.ts";

export const useOffersStore = defineStore('offers-store', {
    state() {
        return {
            offers: [] as Clothes[],
            page: 1,
            total: 0,
            count: 20,
            user: null as unknown as User
        };
    },

    getters: {
        listRequestUrl(): string {
            return `/api/v1/wardrobe/${this.user.id}/offers`;
        },

        lastPage(): number {
            return Math.round(this.total / this.count) + 1;
        },

        hasNextPage(): boolean {
            return this.page < this.lastPage;
        }
    },

    actions: {
        async loadMoreOffers(): Promise<void> {
            return this.fetchOffers(++this.page, this.count);
        },

        async fetchOffers(page: number, count: number): Promise<void> {
            if (!this.user) {
                throw new Error('Unknown user');
            }

            this.page = page;
            this.count = count;

            const response: AxiosResponse = await axios.post(this.listRequestUrl, {
                page: this.page,
                count: this.count
            });

            const data: WardrobeOffersResponse = response.data;

            if (data.success) {
                this.total = data.total;
                data.offers.forEach((item: Clothes) => this.offers.push(item));
            }
        },

        setUser(user: User): void {
            this.user = user;
        }
    }
})
