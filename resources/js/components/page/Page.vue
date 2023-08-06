<template lang="pug">
.page
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
.page {
    padding: 50px 0;
}
</style>
