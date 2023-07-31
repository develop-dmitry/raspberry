<template lang="pug">
.clothes-card
    img.image.clothes-card__photo(:src="photo" :alt="name")
    slot
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
   name: 'ClothesCard',

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
});
</script>

<style lang="scss" scoped>
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.clothes-card {
    position: relative;
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
