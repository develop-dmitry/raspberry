<template lang="pug">
page.detail-look
    template(v-if="isExists")
        template(v-if="look")
            page-title(:title="title")
            .detail-look__row
                .detail-look__photo
                    image.detail-look__image(
                        is="vue:image"
                        :src="look.photo"
                        :alt="look.name"
                    )
                .detail-look__description
                    text(
                        is="vue:text"
                        v-html="look.description"
                    )
                look-composition.detail-look__composition(:look="look")
    template(v-else)
        not-found
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Look} from "../stores/look/types/enitites.ts";
import {mapActions, mapState} from "pinia";
import {useLookStore} from "../stores/look/LookStore.ts";
import Page from "../components/page/Page.vue";
import PageTitle from "../components/page/page-title/PageTitle.vue";
import NotFound from "./NotFound.vue";
import Image from "../components/ui/image/Image.vue";
import Text from "../components/ui/text/Text.vue";
import LookComposition from "../components/look/look-composition/LookComposition.vue";

export default defineComponent({
    name: 'DetailLook',

    components: {
        Page,
        PageTitle,
        NotFound,
        Image,
        Text,
        LookComposition
    },

    data() {
        return {
            isExists: true
        };
    },

    computed: {
        ...mapState(useLookStore, {
            findLook: 'findLook',
            hasLook: 'hasLook'
        }),

        id(): number {
            return Number.parseInt(this.$route.params.id, 10);
        },

        look(): Look|null {
            return this.findLook(this.id);
        },

        title(): string {
            return this.look?.name ?? '';
        }
    },

    methods: {
        ...mapActions(useLookStore, {
            fetchDetailLook: 'fetchDetailLook'
        })
    },

    mounted() {
        if (!this.hasLook((this.id))) {
            this.fetchDetailLook(this.id)
                .then(() => {
                    console.log(this.look)
                    this.isExists = this.hasLook(this.id);
                });
        }
    }
});
</script>

<style scoped lang="scss">
@import "../../css/global/vars";
@import "../../css/global/mixins";

.detail-look {

    &__row {
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 50px;

        @include media-always {
            margin-top: 50px;
        }

        @include media-min($desktop) {
            gap: 50px;
        }

        @include media-max($mobile) {
            flex-direction: column;
            gap: 30px;
        }
    }

    &__photo {
        display: flex;

        @include media-always {
            flex-basis: calc(60% - 50px / 2);
        }
    }

    &__description {
        @include media-always {
            flex-basis: calc(40% - 50px / 2);
        }
    }

    &__image {
        width: 100%;
    }

    &__composition {
        flex-basis: 100%;

        @include media-max($mobile) {
            margin-top: 20px;
            width: 100%;
        }
    }
}
</style>
