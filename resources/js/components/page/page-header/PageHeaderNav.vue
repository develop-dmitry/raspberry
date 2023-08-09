<template lang="pug">
nav.page-header-nav
    ul.page-header-nav__list
        li.page-header-nav__item(
            v-for="(item, index) in menu"
            :key="index"
        )
            link(is="vue:link" :href="item.link" v-html="item.text")
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Link from "../../ui/link/Link.vue";

export default defineComponent({
    name: 'PageHeaderNav',

    components: {
        Link
    },

    data() {
        return {
            menu: [
                {
                    link: '/wardrobe',
                    text: 'Гардероб'
                },
                {
                    link: '/wardrobe/offers',
                    text: 'Предложения'
                }
            ] as Array<{ link: string, text: string }>
        }
    }
})
</script>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

.page-header-nav {
    @include media-always {
        padding: 15px 0;
    }

    &__list {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        justify-content: center;

        @include media-always {
            column-gap: 30px;
        }
    }
}
</style>
