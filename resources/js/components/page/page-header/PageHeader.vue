<template lang="pug">
.page-header
    .container
        page-header-nav
</template>

<script lang="ts">
import {defineComponent} from "vue";
import PageHeaderNav from "./PageHeaderNav.vue";

export default defineComponent({
    name: 'PageHeader',

    components: {
        PageHeaderNav
    }
});
</script>

<style scoped lang="scss">
.page-header {
    border-bottom: 1px solid #000000;
}
</style>
