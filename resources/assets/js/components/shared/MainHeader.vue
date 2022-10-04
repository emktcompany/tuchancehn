<template lang="html">
  <transition name="slideDown">
    <header v-show="showHeader">
      <div class="relative h-full">
        <transition name="slideDown">
          <div v-show="showHeaderBg" class="absolute bg-purple pin"></div>
        </transition>
        <div class="container flex items-center relative h-full">
          <div class="flex-none pr-4 md:pr-8">
            <router-link :to="{ name: 'index' }" class="block text-white hover:text-grey-lighter"><svg-icon class="fill-current" src="~@svg/tuchance.svg"></svg-icon></router-link>
          </div>
          <div class="flex-1 flex justify-end items-center relative">
            <transition name="slideFadeDown"
              @after-leave="expandSearch=true">
              <nav v-if="!showSearch" class="font-semibold flex">
                <auth-nav container-class="flex" link-class="text-white px-6 py-4 no-underline uppercase block leading-none align-middle whitespace-no-wrap hover:text-grey-lighter" />
                <country-menu class="hidden md:block" />
              </nav>
            </transition>
            <div class="w-32 pr-8" :class="{'flex-none': !expandSearch, 'flex-1': expandSearch}">
              <transition name="slideFadeDown">
                <!-- <search-form @toggled="searchToggled" v-if="shouldShowSearch || shouldHideHeader" /> -->
                <search-form button-class="text-white" @toggled="searchToggled" v-if="shouldShowSearch" />
              </transition>
            </div>
            <div class="flex-none w-6">
              <a href @click.prevent="$emit('show-nav')" class="no-underline block text-white"><svg-icon class="stroke-current" src="~@svg/menu-icon.svg"></svg-icon></a>
            </div>
          </div>
        </div>
      </div>
    </header>
  </transition>
</template>

<script>
import {getPosition} from '@/lib/position';

var lastScrollTop = 0, scrollOffset = 100;

export default {
  data() {
    return {
      // show header (applies in mobile)
      showHeader: true,
      // expand search container
      expandSearch: false,
      // show search input
      showSearch: false,
      // show header background
      showHeaderBackground: false,
      // if header should be hidden
      shouldHideHeader: false,
      // show search button
      showSearchButton: false,
    }
  },
  computed: {
    showHeaderBg() {
      const transparentHeader = !!this.$route.meta.transparentHeader;
      return this.showHeaderBackground || (this.shouldShowSearch && !transparentHeader);
    },
    shouldShowSearch() {
      const value = !!!this.$route.meta.hideSearch;

      if (!value) {
        this.searchToggled(false);
      }

      return value || this.showSearchButton;
    }
  },
  created() {
    window.addEventListener("scroll", this.onScroll, false);
    window.addEventListener("resize", this.onResize, false);
    this.onResize();
  },
  methods: {
    onScroll() {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop,
        distance = Math.abs(scrollTop - lastScrollTop),
        realScrollOffset = scrollOffset, offsetElement;

      if (offsetElement = document.querySelector('.header-scroll-offset')) {
        realScrollOffset = getPosition(offsetElement).y;
      }

      if (scrollTop >= realScrollOffset) {
        this.showSearchButton = true;
      } else {
        this.showSearchButton = false;
      }

      if (scrollTop >= scrollOffset) {
        this.showHeaderBackground = true;
      } else {
        this.showHeaderBackground = false;
      }

      if (scrollTop > lastScrollTop){
        if (scrollTop >= scrollOffset && distance > 10) {
          this.showHeader = !this.shouldHideHeader;
        }
      } else {
        if (distance > 5) {
          this.showHeader = true;
        }
      }

      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    },
    onResize() {
      this.shouldHideHeader = window.innerWidth < 768;

      if (!this.shouldHideHeader) {
        this.showHeader = true;
      }
    },
    searchToggled(shown) {
      if (!shown) {
        this.expandSearch = false;
      }

      this.showSearch = shown;
    }
  },
  destroyed() {
    window.removeEventListener("scroll", this.onScroll);
    window.removeEventListener("resize", this.onResize);
  }
}
</script>

<style lang="scss" scoped>
  .search-button {
    left: 100%;
  }
</style>
