<template lang="pug">
div.heading
  slot
</template>

<style scoped lang="scss">
.heading {
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
    display: block;
    font-size: 45px;

    @include media-min($desktop) {
      font-size: 45px;
    }

    @include media-max($mobile) {
      font-size: 32px;
    }
}
</style>
