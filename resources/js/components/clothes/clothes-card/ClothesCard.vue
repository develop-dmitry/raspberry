<script lang="ts">
import {defineComponent} from "vue";
import Image from "#ui/image/Image.vue";

export default defineComponent({
    components: {
        Image
    },

    props: {
        name: {
            type: String,
            required: true
        },
        photo: {
            type: String,
            required: true
        }
    }
})
</script>

<template lang="pug">
.clothes-card
    Image.clothes-card__photo(
        is="vue:image"
        :src="photo"
        :alt="name"
    )
    slot
</template>

<style scoped lang="scss">
.clothes-card {
    height: 400px;
    border-radius: 10px;
    overflow: hidden;

    &__photo {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-right: 10px;
    }
}
</style>
