import {defineStore} from 'pinia';
import {Look, User} from "./types/enitites.ts";
import axios, {AxiosResponse} from "axios";
import {DetailLookResponse, HowFitResponse} from "./types/responses.ts";

export const useLookStore = defineStore('look', {

    state: () => {
        return {
            user: null as unknown as User,
            looks: [] as Look[],
            lookFits: {} as { [id: number]: number }
        };
    },

    getters: {
        findLook: (state) => {
            return (id: number): Look|null => {
                const look: Look|undefined = state.looks.find((look: Look): boolean => {
                    return look.id === id
                });

                return look ? look : null;
            }
        },

        detailRequestUrl: () => {
            return (id: number): string => `/api/v1/look/${id}`;
        },

        howFitRequestUrl: () => {
            return (id: number): string => `/api/v1/look/${id}/how-fit`;
        },

        howFit: (state) => {
            return (id: number): number|null => state.lookFits[id] ?? null;
        }
    },

    actions: {
        async fetchDetailLook(id: number): Promise<void> {
            const response: AxiosResponse = await axios.post(this.detailRequestUrl(id));
            const data: DetailLookResponse = response.data;

            if (response.data.success) {
                data.look.description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';
                this.looks.push(data.look);
            }
        },

        async fetchHowFit(id: number): Promise<void> {
            if (!this.user) {
                throw new Error('Unknown user');
            }

            const response: AxiosResponse = await axios.post(this.howFitRequestUrl(id), {
                user_id: this.user.id
            });
            const data: HowFitResponse = response.data;

            if (data.success) {
                this.lookFits[id] = data.how_fit;
            }
        },

        setUser(user: User): void {
            this.user = user;
        }
    }
});
