<template lang="pug">
.look-composition(v-if="look.clothes.length > 0")
    heading(:level="heading.level") {{ heading.text }}
    .look-composition__clothes
        clothes-card(
            v-for="clothes in look.clothes"
            :name="clothes.name"
            :photo="clothes.photo"
            :key="clothes.id"
        )
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import {Look} from "../../../stores/look/types/enitites.ts";
import Heading from "../../ui/heading/Heading.vue";
import {HeadingLevel} from "../../ui/heading/HeadingLevel.ts";
import ClothesCard from "../../clothes-card/ClothesCard.vue";

export default defineComponent({
    name: 'LookComposition',

    components: {
        Heading,
        ClothesCard
    },

    data() {
        return {
            heading: {
                text: 'Состав образа',
                level: HeadingLevel.H2
            },
        };
    },

    props: {
        look: {
            type: Object as PropType<Look>,
            required: true
        }
    }
});
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

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
