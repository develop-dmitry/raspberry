<script lang="ts">
import {defineComponent} from "vue";
import type Event from "#models/Event.ts";

export default defineComponent({
    props: {
        event: {
            type: Event,
            required: true
        }
    }
});
</script>

<template lang="pug">
.look-event {{ event.name }}
</template>

<style scoped lang="scss">
.look-event {
    border-radius: .5em;
    display: inline-flex;
    line-height: 1.5;
    border-style: solid;
    border-color: #000000;

    @include media-always {
        border-width: 1px;
        font-size: 16px;
        padding: 5px calc(5px + .25em);
    }
}
</style>
