<template lang="pug">
page-title(:title="title")
</template>

<script lang="ts">
import {defineComponent} from "vue";
import PageTitle from "../components/page/page-title/PageTitle.vue";

export default defineComponent({
    name: 'NotFound',

    components: {
        PageTitle
    },

    data() {
        return {
            title: 'Страница не найдена'
        };
    }
});
</script>
