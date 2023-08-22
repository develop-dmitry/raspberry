<template lang="pug">
page
    page-not-found
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Page from "../components/page/Page.vue";
import PageNotFound from "../components/page/page-not-found/PageNotFound.vue";

export default defineComponent({
    name: 'NotFound',

    components: {
        Page,
        PageNotFound
    }
});
</script>
