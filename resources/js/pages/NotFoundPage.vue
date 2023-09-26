<script lang="ts">
import {defineComponent} from "vue";
import Page from "#ui/page/Page.vue";
import Heading from "#ui/heading/Heading.vue";
import Container from "#ui/container/Container.vue";

export default defineComponent({
    components: {
        Page,
        Heading,
        Container
    },

    props: {
        title: {
            type: String,
            default: 'Страница не найдена'
        }
    }
});
</script>

<template lang="pug">
Page
    Container
        Heading {{ title }}
</template>
