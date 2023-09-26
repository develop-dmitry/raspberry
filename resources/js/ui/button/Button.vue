<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    props: {
        href: {
            type: String,
            default: '#'
        }
    }
});
</script>

<template lang="pug">
a.button(:href="href")
    slot
</template>

<style scoped lang="scss">
.button {
    display: inline-block;
    padding: 5px 15px 7px;
    background: #ffffff;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    color: #000000;
}
</style>
