import {defineStore} from 'pinia';
import {Look} from "./types/enitites.ts";
import axios, {AxiosResponse} from "axios";
import {DetailLookResponse} from "./types/responses.ts";

export const useLookStore = defineStore('look', {
    state: () => {
        return {
            looks: [] as Look
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

        hasLook: (state) => {
            return (id: number): boolean => state.findLook(id) !== null;
        },

        detailRequestUrl(): string {
            return (id: number): boolean => {
                return `/api/v1/look/${id}`;
            }
        }
    },

    actions: {
        async fetchDetailLook(id: number): Promise<void> {
            const response: AxiosResponse = await axios.post(this.detailRequestUrl(id));

            if (response.data.success) {
                const data: DetailLookResponse = response.data;
                data.look.description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum';
                this.looks.push(data.look);
            }
        }
    }
});
