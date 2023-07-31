<template lang="pug">
.wardrobe-offers-row(ref="row")
    wardrobe-offers-card(
        v-for="offer in offers"
        :key="offer.id"
        :id="offer.id"
        :name="offer.name"
        :photo="offer.photo"
        :in-wardrobe="inWardrobe.indexOf(offer.id) !== -1"
        @add="$emit('add', $event)"
        @remove="$emit('remove', $event)"
    )
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {WardrobeOffer} from "../types";
import WardrobeOffersCard from "./WardrobeOffersCard.vue";
export default defineComponent({
    name: 'WardrobeOffersRow',

    components: {
        WardrobeOffersCard
    },

    emits: ['load', 'add', 'remove'],

    props: {
        offers: {
            type: Array<WardrobeOffer>,
            required: true
        },
        inWardrobe: {
            type: Array<number>,
            required: true
        },
        page: {
            type: Number,
            required: true
        },
        lastPage: {
            type: Number,
            required: true
        },
        isLoadingOffers: {
            type: Boolean,
            required: true
        }
    },

    methods: {
        hasNextPage() {
            return this.page < this.lastPage;
        },

        needLoadOffers() {
            if (!this.$refs.row) {
                return false;
            }

            const row: HTMLElement = this.$refs.row as HTMLElement;
            const lastElement: HTMLElement|null = row.querySelector(':scope > :last-child');

            if (!lastElement) {
                return false;
            }

            return window.scrollY > lastElement.offsetTop - window.innerHeight;
        },
    },

    mounted() {
        const checkNeedLoadOffers = () => {
            if (this.isLoadingOffers) {
                return;
            }

            if (!this.hasNextPage()) {
                window.removeEventListener('scroll', checkNeedLoadOffers);
            }

            if (this.needLoadOffers()) {
                this.$emit('load');
            }
        }

        window.addEventListener('scroll', checkNeedLoadOffers);
    }
})
</script>

<style lang="scss" scoped>
@import "../../../../css/global/mixins";
@import "../../../../css/global/vars";

.wardrobe-offers-row {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;

    @include media-always {
        margin-top: 50px;
    }

    > * {
        flex-basis: calc(33.3% - 30px * 2 / 3);

        @include media-max($mobile) {
            flex-basis: 100%;
        }
    }
}
</style>
