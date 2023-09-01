<template lang="pug">
page.wardrobe
    page-title(:title="title" :total="this.wardrobe.length")
    .wardrobe__row
        wardrobe-clothes-card(
            v-for="item in wardrobe"
            :key="item.id"
            :clothes="item"
        )
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {mapActions, mapState} from "pinia";
import {useWardrobeStore} from "../stores/wardrobe/WardrobeStore.ts";
import Page from "../components/page/Page.vue";
import PageTitle from "../components/page/page-title/PageTitle.vue";
import WardrobeClothesCard from "../components/wardrobe/wardrobe-clothes-card/WardrobeClothesCard.vue";

export default defineComponent({
    name: 'Wardrobe',

    components: {
        WardrobeClothesCard,
        Page,
        PageTitle
    },

    data() {
        return {
            title: 'Гардероб'
        };
    },

    props: {
        apiToken: {
            type: String,
            required: true
        }
    },

    computed: {
        ...mapState(useWardrobeStore, ['wardrobe']),
    },

    methods: {
        ...mapActions(useWardrobeStore, {
            fetchWardrobe: 'fetchWardrobe',
            setApiToken: 'setApiToken'
        })
    },

    created() {
        this.setApiToken(this.apiToken);
        this.fetchWardrobe();
    }
});
</script>

<style scoped lang="scss">
@import "../../css/global/vars";
@import "../../css/global/mixins";

.wardrobe {

    &__row {
        display: flex;
        flex-wrap: wrap;

        @include media-always {
            margin-top: 50px;
            gap: 30px;
        }

        > * {
            flex-basis: calc(33.3% - 30px * 2 / 3);

            @include media-max($mobile) {
                flex-basis: 100%;
            }
        }
    }
}
</style>
