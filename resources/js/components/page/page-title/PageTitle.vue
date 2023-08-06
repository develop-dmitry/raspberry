<template lang="pug">
h1.page-title {{ title }}
    span.page-title__count(v-if="total") {{ total }}
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'PageTitle',

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
    line-height: 1.2;
    margin: 0;
    display: block;
    font-size: 45px;

    @include media-min($desktop) {
        font-size: 45px;
    }

    @include media-max($mobile) {
        font-size: 30px;
    }

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
