<script lang="ts">
import {defineComponent, PropType, ref, computed, Ref} from "vue";
import ClothesCard from "#components/clothes/clothes-card/ClothesCard.vue";
import Button from "#ui/button/Button.vue";
import {useWardrobeStore} from "#stores/wardrobe-store/WardrobeStore.ts";
import type Clothes from "#models/Clothes.ts";

export default defineComponent({
    emits: [
        'remove',
        'add'
    ],

    components: {
        ClothesCard,
        Button
    },

    props: {
        clothes: {
            type: Object as PropType<Clothes>,
            required: true
        }
    },

    setup({ clothes }, { emit }) {
        const wardrobeStore = useWardrobeStore();

        const isActive: Ref<boolean> = ref(false);
        const inWardrobe = computed<boolean>(() => wardrobeStore.inWardrobe(clothes.id));

        const removeClothes = async (): Promise<void> => {
            try {
                const success = await wardrobeStore.removeClothes({ clothes_id: clothes.id });

                if (success) {
                    emit('remove');
                }
            } catch (e) {
                console.error(e);
            }
        };

        const addClothes = async (): Promise<void> => {
            try {
                const success = await wardrobeStore.addClothes({ clothes_id: clothes.id });

                if (success) {
                    emit('add');
                }
            } catch (e) {
                console.error(e);
            }
        }

        return {
            isActive,
            inWardrobe,
            removeClothes,
            addClothes
        }
    }
});
</script>

<template lang="pug">
ClothesCard.wardrobe-clothes-card(
    :class="{'wardrobe-clothes-card_active': isActive}"
    :name="clothes.name"
    :photo="clothes.photo"
    @click.prevent="isActive = true"
    @mouseover="isActive = true"
    @mouseleave="isActive = false"
)
    .wardrobe-clothes-card__info
        Button(
            v-if="inWardrobe"
            is="vue:button"
            @click.prevent="removeClothes"
        ) Удалить из гардероба
        Button(
            v-else
            is="vue:button"
            @click.prevent="addClothes"
        ) Добавить в гардероб
        .wardrobe-clothes-card__name {{ clothes.name }}
</template>

<style scoped lang="scss">
.wardrobe-clothes-card {
    position: relative;
    transition: all .2s ease-in-out;

    &_active {
        box-shadow: 0 10px 15px 0 rgba(0, 0, 0, .2);

        @include media-min($mobile) {
            transform: scale(1.05);
        }

        .wardrobe-clothes-card__info {
            opacity: 1;
            z-index: initial;
        }
    }

    &__info {
        position: absolute;
        left: 0;
        top: 0;
        background-color: rgba(0, 0, 0, 0.4);
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: -1;
        opacity: 0;
        transition: all .2s ease-in-out;
    }

    &__name {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;


        @include media-always {
            font-size: 16px;
            padding: 10px;
        }
    }
}
</style>
