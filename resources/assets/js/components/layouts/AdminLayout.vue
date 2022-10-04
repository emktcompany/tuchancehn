<template lang="html">
  <div class="container pt-32">
    <breadcrumbs-list />
    <div class="flex flex-col md:flex-row py-8 -mx-4">
      <div class="md:w-1/4 lg:w-1/5 px-4" v-click-outside="close">
        <div class="text-grey-darker flex p-4 border-grey bg-grey-lighter justify-between md:hidden hover:bg-grey cursor-pointer rounded" v-collapse-toggle="'menu'">
          <div class="flex-none font-dosis font-bold">
            Menú
          </div>
          <div class="flex-none w-6">
            <a href @click.prevent class="no-underline block text-grey-darker"><svg-icon class="stroke-current" src="~@svg/menu-icon.svg"></svg-icon></a>
          </div>
        </div>
        <v-collapse-wrapper ref="menu">
          <div class="mt-2 md:mt-0" v-collapse-content>
            <admin-nav @clicked="close" />
          </div>
        </v-collapse-wrapper>
      </div>
      <div class="md:w-3/4 lg:w-4/5 px-4">
        <transition mode="out-in"
          enter-active-class="animated-fast animated fadeIn"
          leave-active-class="animated-fast animated fadeOut">
          <router-view :key="$route.fullPath"></router-view>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import DetectsMobile from '../../mixins/DetectsMobile';

export default {
  mixins: [DetectsMobile],
  methods: {
    handleResize() {
      if (this.isMobile) {
        this.$refs.menu.close();
      } else {
        this.$refs.menu.open();
      }
    },
    close() {
      this.isMobile && this.$refs.menu.close();
    }
  }
}
</script>

<style lang="scss" scoped>
.v-collapse-content-end {
  max-height: 1000px;
}
</style>
