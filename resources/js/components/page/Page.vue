<template lang="pug">
.page
    page-header
    .page__content
        .container
            slot
</template>

<script lang="ts">
import {defineComponent} from "vue";
import PageHeader from "./page-header/PageHeader.vue";

export default defineComponent({
    name: 'Page',

    components: {
        PageHeader
    }
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
