<script lang="ts">
import {defineComponent, PropType} from "vue";
import Page from "#ui/page/Page.vue";
import Heading from "#ui/heading/Heading.vue";
import ClothesCard from "#components/wardrobe/clothes-card/ClothesCard.vue";
import Container from "#ui/container/Container.vue";
import type Clothes from "#models/Clothes.ts";
import {useWardrobeStore} from "#stores/wardrobe-store/WardrobeStore.ts";

export default defineComponent({
    components: {
        Page,
        Heading,
        ClothesCard,
        Container
    },

    props: {
        items: {
            type: Array as PropType<Clothes[]>,
            default: () => []
        }
    },

    setup({ items }) {
        const wardrobeStore = useWardrobeStore();

        wardrobeStore.setClothes(items);

        const onRemove = (id: number) => {
            const clothes = wardrobeStore.clothes.filter((item: Clothes) => item.id !==id);
            wardrobeStore.setClothes(clothes);
        }

        return {
            wardrobeStore,
            onRemove
        }
    }
});
</script>

<template lang="pug">
Page.wardrobe
    Container
        Heading Гардероб
        .wardrobe__row
            ClothesCard(
                v-for="clothes in wardrobeStore.clothes"
                :key="clothes.id"
                :clothes="clothes"
                @remove="onRemove(clothes.id)"
            )
</template>

<style scoped lang="scss">
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
