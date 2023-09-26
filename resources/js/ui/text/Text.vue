<template lang="pug">
.text
    slot
</template>

<style scoped lang="scss">
.text {
    color: #000000;

    @include media-always {
        font-size: 16px;
        line-height: 1.4;
    }
}
</style>
