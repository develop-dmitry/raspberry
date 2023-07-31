<template lang="pug">
.page.wardrobe-offers
    .container
        h1.page-title Добавьте в свой гардероб
            span.page-title__count {{ total }}
        wardrobe-offers-row(
            :offers="offers"
            :in-wardrobe="inWardrobe"
            :last-page="lastPage"
            :page="page"
            :is-loading-offers="isLoadingOffers"
            @load="nextPage"
            @add="addClothes"
            @remove="removeClothes"
        )
</template>

<script lang="ts">
import {defineComponent} from "vue";
import WardrobeOffersRow from "./WardrobeOffersRow.vue";
import {WardrobeOffer, WardrobeOffersResponse, AddClothesResponse, RemoveClothesResponse} from "../types";
import axios from "axios";

export default defineComponent({
    name: 'WardrobeOffers',

    components: {
        WardrobeOffersRow
    },

    data() {
        return {
            offers: [] as Array<WardrobeOffer>,
            inWardrobe: [] as Array<number>,
            page: 1,
            count: 21,
            total: 0,
            isLoadingOffers: false
        };
    },

    props: {
        userId: {
            type: Number,
            required: true
        }
    },

    computed: {
        listRequestUrl() {
            return `/api/v1/wardrobe/${this.userId}/offers`;
        },

        addRequestUrl() {
            return `/api/v1/wardrobe/${this.userId}/add`;
        },

        removeRequestUrl() {
            return `/api/v1/wardrobe/${this.userId}/remove`;
        },

        lastPage() {
            return Math.round(this.total / this.count) + 1;
        }
    },

    methods: {
        removeClothes(clothesId: number): void {
            this.removeRequest(clothesId)
                .then(response => this.handleRemoveRequest(response, clothesId));
        },

        async removeRequest(clothesId: number): Promise<RemoveClothesResponse> {
            const response = await axios.post(this.removeRequestUrl, {clothes_id: clothesId});

            return response.data;
        },

        handleRemoveRequest(response: RemoveClothesResponse, clothesId: number): void {
            if (response.success) {
                this.inWardrobe = this.inWardrobe.filter(id => id !== clothesId);
            }
        },

        addClothes(clothesId: number): void {
            this.addRequest(clothesId)
                .then(response => this.handleAddResponse(response, clothesId));
        },

        async addRequest(clothesId: number): Promise<AddClothesResponse> {
            const response = await axios.post(this.addRequestUrl, {clothes_id: clothesId});

            return response.data;
        },

        handleAddResponse(response: AddClothesResponse, clothesId: number): void {
            if (response.success) {
                this.inWardrobe.push(clothesId);
            }
        },

        loadOffers(): void {
            this.isLoadingOffers = true;

            this.listRequest()
                .then(response => this.handleListResponse(response))
                .then(() => this.isLoadingOffers = false);
        },

        async listRequest(): Promise<WardrobeOffersResponse> {
            const response = await axios.post(this.listRequestUrl, {page: this.page, count: this.count});

            return response.data;
        },

        handleListResponse(response: WardrobeOffersResponse): void {
            if (!response.success) {
                return;
            }

            this.total = response.total;

            response.offers.forEach(offer => this.offers.push(offer));
        },

        nextPage(): void {
            this.page++;
            this.loadOffers();
        }
    },

    mounted() {
        this.loadOffers();
    }
});
</script>
