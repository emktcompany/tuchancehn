<template lang="html">
  <section class="relative bg-blue main-hero">
    <div class="flex items-center relative h-full pt-24 overflow-hidden">
      <div class="w-full relative mb-20 pt-16">
        <carousel :per-page="1" :pagination-padding="5" pagination-active-color="#F7A765" pagination-color="#1FBD95">
          <slide v-for="banner in banners" :key="banner.id">
            <div class="container">
              <div class="clearfix relative">
                <div class="float-right w-full sm:w-4/5 md:w-3/4 overflow-hidden">
                  <div class="xs:relative xs:h-64">
                    <img :src="banner.image.url" alt="" class="block xs:absolute xs:h-full xs:w-auto pin-t pin-r">
                  </div>
                </div>
                <div class="absolute h-full flex items-center w-2/3 sm:w-1/3 pl-4 sm:pl-0 slide-caption z-50">
                  <div class="">
                    <div class="text-cyan text-xl lg:text-3xl mb-4">{{banner.text}}</div>
                    <div class="text-white font-dosis text-2xl md:text-4xl lg:text-5xl xl:text-6xl mb-4">{{banner.name}}</div>
                    <div><a :href="banner.link" class="text-orange text-lg lg:text-2xl inline-block no-underline flex items-center">{{banner.link_text}} <svg-icon class="ml-3 stroke-current fill-none" src="~@svg/continue.svg"></svg-icon></a></div>
                  </div>
                </div>
              </div>
            </div>
          </slide>
        </carousel>
        <div class="search-box absolute pin-x md:-mt-20 -mt-16">
          <div class="container flex justify-end">
            <div class="w-full sm:w-4/5 md:w-3/5 md:pr-6 sm:pr-10 pl-10 md:pl-0 header-scroll-offset">
              <search-form class="pl-24 relative" button-class="md:w-24 md:h-24 w-16 h-16 flex items-center justify-center bg-teal text-blue" input-container-class="flex-none w-full flex items-center bg-teal md:h-24 h-16" input-wrapper-class="pr-8" input-class="text-blue border-0 text-2xl bg-teal" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="absolute pin-x pin-t">
      <div class="container relative h-24">
        <div class="absolute dot intro-bg bg-red animated zoomIn"></div>
        <div class="dot absolute bg-orange" style="top:220px;right:0"></div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    banners: {
      type: Array,
      required: true
    }
  }
}
</script>

<style scoped>
  .intro-bg {
    width: 390px;
    transform-origin: 245px 256px;
    top: 0;
    left: 0;
    top: -205px;
    left: -195px;
  }
</style>
