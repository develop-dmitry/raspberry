<template lang="pug">
img.image(:src="src" :alt="alt")
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'Image',

    props: {
        src: {
            type: String,
            required: true
        },

        alt: String
    }
});
</script>

<style scoped lang="scss">
.image {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>
