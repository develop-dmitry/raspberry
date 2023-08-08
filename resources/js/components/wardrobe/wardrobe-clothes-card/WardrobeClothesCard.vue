<template lang="pug">
clothes-card.wardrobe-clothes-card(
    :class="{'wardrobe-clothes-card_active': isActive}"
    :name="clothes.name"
    :photo="clothes.photo"
    @click.prevent="isActive = true"
    @mouseover="isActive = true"
    @mouseleave="isActive = false"
)
    .wardrobe-clothes-card__info
        button(
            v-if="inWardrobe"
            is="vue:button"
            @click.prevent="removeClothes(clothes)"
        ) Удалить из гардероба
        button(
            v-else
            is="vue:button"
            @click.prevent="addClothes(clothes)"
        ) Добавить в гардероб
        .wardrobe-clothes-card__name {{ clothes.name }}
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import ClothesCard from "../../clothes-card/ClothesCard.vue";
import {mapActions, mapState} from "pinia";
import {useWardrobeStore} from "../../../stores/wardrobe/WardrobeStore.ts";
import {Clothes} from "../../../stores/wardrobe/types/enitities.ts";
import Button from "../../ui/button/Button.vue";

export default defineComponent({
    name: 'WardrobeClothesCard',

    components: {
        ClothesCard,
        Button
    },

    data() {
        return {
            isActive: false
        };
    },

    props: {
        clothes: {
            type: Object as PropType<Clothes>,
            required: true
        }
    },

    computed: {
        ...mapState(useWardrobeStore, {
            inWardrobeStore: 'inWardrobe'
        }),

        inWardrobe(): boolean {
            return this.inWardrobeStore(this.clothes.id);
        }
    },

    methods: {
        ...mapActions(useWardrobeStore, {
            addClothes: 'addClothes',
            removeClothes: 'removeClothes'
        })
    }
})
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

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
