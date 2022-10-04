<template lang="html">
  <div class="container pt-32 pb-12">
    <breadcrumbs-list/>
    <div class="pt-12 flex -mx-4">
      <div class="flex-none px-4 xs:hidden" v-if="!hideImage">
        <img src="~@img/about-picture.jpg" alt="">
      </div>
      <div class="flex-1 text-justify px-4">
        <div class="page-content" v-html="content"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    content: {
      type: String,
      required: true
    },
    hideImage: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      data: null
    };
  }
}
</script>

<style lang="scss" scoped>
  .page-content {
    p:not(.ignore) {
      @apply leading-loose mb-4;
    }
    h1, h2, h3 {
      &:not(.ignore) {
        @apply leading-loose mb-4 text-red font-dosis ;
      }
    }
    li:not(.ignore) {
      @apply leading-loose mb-1;
    }
    a:not(.ignore) {
      @apply text-red ;
    }
  }
</style>
