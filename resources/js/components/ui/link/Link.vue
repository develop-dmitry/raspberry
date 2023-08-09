<template lang="pug">
a.link(:href="href")
    slot
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'Link',

    props: {
        href: {
            type: String,
            required: true
        }
    }
})
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.link {
    text-decoration: none;
    color: #000000;

    @include media-always {
        font-size: 16px;
    }

    &:hover,
    &:focus {
        text-decoration: none;
    }
}
</style>
