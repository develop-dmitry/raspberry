<template lang="pug">
clothes-card.wardrobe-offers-card(
    :class="{'wardrobe-offers-card_active': isActive}"
    :name="name"
    :photo="photo"
    @click.prevent="isActive = true"
    @mouseover="isActive = true"
    @mouseleave="isActive = false"
)
    slot
        .wardrobe-offers-card__info
            span.button(
                v-if="inWardrobe"
                @click.prevent="$emit('remove', id)"
            ) Удалить из гардероба
            span.button(
                v-else
                @click.prevent="$emit('add', id)"
            ) Добавить в гардероб
            .wardrobe-offers-card__name {{ name }}
</template>

<script lang="ts">
import ClothesCard from "../ClothesCard/ClothesCard.vue";

export default {
    name: 'WardrobeOffersCard',

    components: {
        ClothesCard
    },

    emits: ['add', 'remove'],

    data() {
        return {
            isActive: false
        };
    },

    props: {
        id: {
            type: Number,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        photo: {
            type: String,
            required: true
        },
        inWardrobe: {
            type: Boolean,
            required: true
        }
    },
}
</script>

<style lang="scss" scoped>
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.wardrobe-offers-card {
    transition: all .2s ease-in-out;

    &_active {
        box-shadow: 0 10px 15px 0 rgba(0, 0, 0, .2);

        @include media-min($mobile) {
            transform: scale(1.05);
        }

        .wardrobe-offers-card__info {
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
