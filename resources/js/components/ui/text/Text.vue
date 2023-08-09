<template lang="pug">
.text
    slot
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'Text'
});
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.text {
    color: #000000;

    @include media-always {
        font-size: 16px;
        line-height: 1.4;
    }
}
</style>
