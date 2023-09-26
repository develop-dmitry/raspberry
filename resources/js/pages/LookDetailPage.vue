<script lang="ts">
import {defineComponent, PropType, computed} from "vue";
import Page from "#ui/page/Page.vue";
import Container from "#ui/container/Container.vue";
import Heading from "#ui/heading/Heading.vue";
import Image from "#ui/image/Image.vue";
import LookEvent from "#components/look/look-event/LookEvent.vue";
import LookComposition from "#components/look/look-composition/LookComposition.vue";
import type Look from "#models/Look";
import Text from "#ui/text/Text.vue";
import {useLookStore} from "#stores/look-store/LookStore.ts";

export default defineComponent({
    components: {
        Page,
        Container,
        Heading,
        Image,
        Text,
        LookEvent,
        LookComposition
    },

    props: {
        look: {
            type: Object as PropType<Look>,
            require: true
        }
    },

    setup({ look }) {
        const lookStore = useLookStore();

        const title = computed((): string => look?.name ?? '');
        const pickerScore = computed((): number | null => (look) ? lookStore.pickerScore(look.id) : null);

        if (look) {
            lookStore.fetchPickerScore({ lookId: look.id });
        }

        return {
            title,
            pickerScore
        }
    }
});
</script>

<template lang="pug">
Page
    Container
        Heading {{ title }}
        .detail-look__row
            .detail-look__photo
                Image.detail-look__image(
                    is="vue:image"
                    :src="look.photo"
                    :alt="look.name"
                )
            .detail-look__description
                Text.detail-look__how-fit(
                    v-if="pickerScore"
                    is="vue:text"
                ) {{ `Подходит вам на ${pickerScore}%` }}
                .detail-look__events(v-if="look.events.length > 0")
                    LookEvent(
                        v-for="(event, index) in look.events"
                        :event="event"
                        :key="index"
                    )
                Text(
                    is="vue:text"
                ) Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
            LookComposition(:clothes="look.clothes")
</template>

<style scoped lang="scss">
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
