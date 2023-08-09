<template lang="pug">
div.heading(:class="classes")
    slot
</template>

<script lang="ts">
import {defineComponent, PropType} from "vue";
import {HeadingLevel} from "./HeadingLevel.ts";

export default defineComponent({
    name: 'Heading',

    props: {
        level: {
            type: Number as PropType<HeadingLevel>,
            required: true
        }
    },

    computed: {
        classes(): string[] {
            const classes: string = [];

            switch (this.level) {
                case HeadingLevel.H1:
                    classes.push('heading_h1');
                    break;
                case HeadingLevel.H2:
                    classes.push('heading_h2');
                    break;
            }

            return classes;
        }
    }
});
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.heading {
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    display: block;


    &_h1 {
        font-size: 45px;

        @include media-min($desktop) {
            font-size: 45px;
        }

        @include media-max($mobile) {
            font-size: 32px;
        }
    }

    &_h2 {
        font-size: 32px;

        @include media-min($desktop) {
            font-size: 32px;
        }

        @include media-max($mobile) {
            font-size: 24px;
        }
    }

    &:not(:last-child) {
        @include media-always {
            margin-bottom: 1.2em;
        }
    }
}
</style>
