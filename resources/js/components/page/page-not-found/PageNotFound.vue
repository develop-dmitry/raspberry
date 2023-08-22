<template lang="pug">
page-title(:title="title")
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Page from "../Page.vue";
import PageTitle from "../page-title/PageTitle.vue";

export default defineComponent({
    name: 'PageNotFound',

    components: {
        Page,
        PageTitle
    },

    props: {
        title: {
            type: String,
            default: 'Страница не найдена'
        }
    }
});
</script>
