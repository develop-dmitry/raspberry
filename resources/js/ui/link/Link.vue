<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        href: {
            type: String,
            required: true
        }
    }
});
</script>

<template lang="pug">
a.link(:href="href")
    slot
</template>

<style scoped lang="scss">
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
