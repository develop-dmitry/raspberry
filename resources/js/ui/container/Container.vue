<template lang="pug">
.container
    slot
</template>

<style scoped lang="scss">
.container {
    box-sizing: border-box;
    margin: 0 auto;

    @include media-always {
        max-width: 1200px;
        padding: 0 15px;
    }
}

</style>
