<template lang="pug">
.page
    .page__content
        slot
</template>

<style scoped lang="scss">
.page {

    &__content {
        @include media-always {
            padding: 50px 0;
        }
    }
}
</style>
