<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        src: {
            type: String,
            required: true
        },
        alt: String
    }
})
</script>

<template lang="pug">
img.image(:src="src" :alt="alt")
</template>

<style scoped lang="scss">
.image {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>
