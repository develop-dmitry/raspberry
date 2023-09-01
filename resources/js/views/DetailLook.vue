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
                    text.detail-look__how-fit(
                        v-if="howFit"
                        is="vue:text"
                    ) {{ `Подходит вам на ${howFit}%` }}
                    .detail-look__events
                        look-event(
                            v-for="(event, index) in look.events"
                            :event="event"
                            :key="index"
                        )
                    text(
                        is="vue:text"
                        v-html="look.description"
                    )
                look-composition.detail-look__composition(:look="look")
    template(v-else)
        page-not-found
</template>

<script lang="ts">
import {defineComponent} from "vue";
import {Look} from "../stores/look/types/enitites.ts";
import {mapActions, mapState} from "pinia";
import {useLookStore} from "../stores/look/LookStore.ts";
import Page from "../components/page/Page.vue";
import PageTitle from "../components/page/page-title/PageTitle.vue";
import Image from "../components/ui/image/Image.vue";
import Text from "../components/ui/text/Text.vue";
import LookComposition from "../components/look/look-composition/LookComposition.vue";
import PageNotFound from "../components/page/page-not-found/PageNotFound.vue";
import LookEvent from "../components/look/look-event/LookEvent.vue";

export default defineComponent({
    name: 'DetailLook',

    components: {
        Page,
        PageTitle,
        PageNotFound,
        Image,
        Text,
        LookComposition,
        LookEvent
    },

    data() {
        return {
            isExists: true
        };
    },

    props: {
        apiToken: {
            type: String,
            required: true
        }
    },

    computed: {
        ...mapState(useLookStore, {
            findLook: 'findLook',
            howFitStore: 'howFit'
        }),

        id(): number {
            if (typeof this.$route.params.id === 'string') {
                return Number.parseInt(this.$route.params.id, 10);
            }

            return 0;
        },

        look(): Look|null {
            return this.findLook(this.id);
        },

        title(): string {
            return this.look?.name ?? '';
        },

        howFit(): number|null {
            return this.howFitStore(this.id);
        }
    },

    methods: {
        ...mapActions(useLookStore, {
            fetchDetailLook: 'fetchDetailLook',
            fetchHowFit: 'fetchHowFit',
            setApiToken: 'setApiToken'
        })
    },

    mounted() {
        this.setApiToken(this.apiToken);

        if (!this.look) {
            this.fetchDetailLook(this.id)
                .then(() => {
                    this.isExists = this.look !== null;
                });
        }

        if (!this.howFit) {
            this.fetchHowFit(this.id);
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

    &__events {
        display: flex;
        flex-wrap: wrap;

        @include media-always {
            gap: 15px;
        }

        &:not(:last-child) {
            @include media-always {
                margin-bottom: 30px;
            }
        }
    }

    &__how-fit {
        @include media-always {
            margin-bottom: 30px;
        }
    }
}
</style>
