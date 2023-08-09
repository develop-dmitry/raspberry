<template lang="pug">
heading.page-title(:level="level") {{ title }}
    span.page-title__count(v-if="total") {{ total }}
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Heading from "../../ui/heading/Heading.vue";
import {HeadingLevel} from "../../ui/heading/HeadingLevel.ts";

export default defineComponent({
    name: 'PageTitle',

    components: {
        Heading
    },

    data() {
        return {
            level: HeadingLevel.H1
        }
    },

    props: {
        title: {
            type: String,
            required: true
        },
        total: Number
    }
});
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";


.page-title {

    &__count {
        font-size: 50%;
        display: inline-block;
        transform: translateY(-75%);

        @include media-always {
            margin-left: 5px;
        }
    }
}
</style>
