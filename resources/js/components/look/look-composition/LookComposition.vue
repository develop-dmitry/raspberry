<script lang="ts">
import {defineComponent, PropType} from "vue";
import type Clothes from "#models/Clothes.ts";
import Heading from "#ui/heading/Heading.vue";
import ClothesCard from "#components/clothes/clothes-card/ClothesCard.vue";

export default defineComponent({
    components: {
        Heading,
        ClothesCard
    },

    props: {
        clothes: {
            type: Array as PropType<Clothes[]>,
            default: () => []
        }
    }
})
</script>

<template lang="pug">
.look-composition(v-if="clothes.length > 0")
    .look-composition__clothes
        clothes-card(
            v-for="clothes in clothes"
            :name="clothes.name"
            :photo="clothes.photo"
        :key="clothes.id"
            )
</template>

<style scoped lang="scss">
.look-composition {

  &__clothes {
    display: grid;
    grid-template-columns: repeat(3, 1fr);

    @include media-always {
      gap: 30px;
    }

    @include media-max($mobile) {
      grid-template-columns: 1fr;
    }
  }
}
</style>
