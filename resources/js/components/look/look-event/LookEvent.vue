<script lang="ts">
import {defineComponent, PropType} from 'vue'
import {Event} from '../../../stores/look/types/enitites.ts';

export default defineComponent({
    name: 'LookEvent',

    props: {
        event: {
            type: Object as PropType<Event>,
            required: true
        },
    }
})
</script>

<template lang="pug">
.look-event {{ event.name }}
</template>

<style scoped lang="scss">
@import "../../../../css/global/vars";
@import "../../../../css/global/mixins";

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
