<template lang="pug">
.page
    .page__content
        .container
            slot
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'Page'
});
</script>

<style scoped lang="scss">
@import "../../../css/global/vars";
@import "../../../css/global/mixins";

.page {

    &__content {
        @include media-always {
            padding: 50px 0;
        }
    }
}
</style>
