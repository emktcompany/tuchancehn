<template lang="html">
  <div class="relative z-10" v-click-outside="hideCountrySelect" v-if="$country">
    <a href @click.prevent="toggleCountrySelect" class="text-white px-6 py-4 no-underline uppercase flex items-center leading-none align-middle whitespace-no-wrap hover:text-grey-lighter">{{ $country.abbr }} <span class="inline-block ml-4"><svg-icon class="fill-current block" src="~@svg/dropdown-icon.svg"></svg-icon></span></a>
    <transition name="slideFadeDown">
      <div v-show="showCountrySelect" class="dropdown-menu min-w-full absolute pin-l bg-purple py-2 shadow-lg rounded-b-lg uppercase z-50">
        <a :href="`https://${country.domain}`" target="_blank" v-for="country in $countries" :key="country.code" v-if="$country.code != country.code">{{country.abbr}}</a>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCountrySelect: false
    }
  },
  methods: {
    toggleCountrySelect() {
      this.showCountrySelect = !this.showCountrySelect;
    },
    hideCountrySelect() {
      this.showCountrySelect = false;
    },
  }
}
</script>

<style lang="scss" scoped>
  .dropdown-menu {
    top: 100%;

    a {
      @apply px-6 block no-underline py-3 text-white whitespace-no-wrap ;

      &:hover {
        @apply text-grey-lighter bg-purple-dark ;
      }
    }
  }
</style>
