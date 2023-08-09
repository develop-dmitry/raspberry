<template lang="pug">
page.wardrobe-offers
    page-title(:title="title" :total="this.total")
    .wardrobe-offers__row(ref="row")
        wardrobe-clothes-card(
            v-for="item in offers"
            :key="item.id"
            :clothes="item"
        )
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import Page from "../components/page/Page.vue";
import PageTitle from "../components/page/page-title/PageTitle.vue";
import {mapActions, mapState} from "pinia";
import {useOffersStore} from "../stores/wardrobe/OffersStore.ts";
import WardrobeClothesCard from "../components/wardrobe/wardrobe-clothes-card/WardrobeClothesCard.vue";
import {useWardrobeStore} from "../stores/wardrobe/WardrobeStore.ts";
import {User} from "../stores/wardrobe/types/enitities.ts";

export default defineComponent({
    name: 'WardrobeOffers',

    components: {
        WardrobeClothesCard,
        Page,
        PageTitle
    },

    data() {
        return {
            title: 'Добавьте в свой гардероб',
            count: 21,
            isLoading: false
        };
    },

    props: {
        user: {
            type: Object as PropType<User>,
            required: true
        }
    },

    computed: {
        ...mapState(useOffersStore, ['offers', 'hasNextPage', 'total'])
    },

    methods: {
        ...mapActions(useOffersStore, {
            fetchOffers: 'fetchOffers',
            loadMoreOffers: 'loadMoreOffers',
            setOffersUser: 'setUser'
        }),

        ...mapActions(useWardrobeStore, {
            fetchWardrobe: 'fetchWardrobe',
            setWardrobeUser: 'setUser'
        })
    },

    mounted() {
        window.addEventListener('scroll', () => {
            const row: HTMLElement = this.$refs.row as HTMLElement;
            const lastElement: HTMLElement|null = row.querySelector(':scope > :last-child');

            if (!lastElement) {
                return;
            }

            const onBottom=  window.scrollY > lastElement.offsetTop - window.innerHeight;

            if (onBottom && this.hasNextPage && !this.isLoading) {
                this.isLoading = true;
                this.loadMoreOffers()
                    .then(() => this.isLoading = false);
            }
        })
    },

    created() {
        this.setOffersUser(this.user);
        this.setWardrobeUser(this.user)

        this.fetchOffers(1, this.count);
        this.fetchWardrobe();
    }
})
</script>

<style scoped lang="scss">
@import "../../css/global/vars";
@import "../../css/global/mixins";

.wardrobe-offers__row {
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
