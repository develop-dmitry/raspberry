import {defineStore} from "pinia";
import HowFitRequest from "#stores/look-store/requests/HowFitRequest.ts";
import HowFitResponse from "#stores/look-store/responses/HowFitResponse.ts";
import axios, {AxiosResponse} from "axios";

export const useLookStore = defineStore('look', {
    state: () => {
        return {
            pickerScores: {} as {[index: number]: number}
        }
    },

    getters: {
        pickerScore(state) {
            return (lookId: number): number | null => state.pickerScores[lookId] ?? null;
        }
    },

    actions: {
        async fetchPickerScore(request: HowFitRequest): Promise<void> {
            const response: AxiosResponse = await axios.post(`/api/v1/look/${request.lookId}/how-fit`);
            const data: HowFitResponse = response.data;

            if (!data.success) {
                throw new Error(data.message)
            }

            this.pickerScores[request.lookId] = data.how_fit;
        }
    }
});
