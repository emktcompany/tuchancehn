<template lang="html">
  <router-link :to="{name: route}" v-ripple class="bg-white shadow-md px-3 md:px-1 lg:px-3 py-4 flex no-underline group transition-all md:flex-col lg:flex-row" :class="hoverClass">
    <div :class="[bgColor, iconHoverClass]" class="rounded-full flex-none text-white w-12 h-12 flex items-center justify-center transition-all group-hover:bg-white mx-auto">
      <slot><svg-icon src="~@svg/icons/solid/user-graduate.svg" class="w-8 h-8 fill-current" /></slot>
    </div>
    <div class="flex-1 pl-2 text-grey-darkest group-hover:text-white md:flex lg:block items-center md:mt-3 lg:mt-0">
      <div class="text-2xl md:pr-1 lg:pr-0 mb-2 md:mb-0 lg:mb-2">{{count}}</div>
      <div class="text-2xs uppercase">{{label}}</div>
    </div>
  </router-link>
</template>

<script>
export default {
  props: {
    bgColor: {
      default: 'bg-cyan',
      type: String
    },
    count: {
      type: Number,
      default: 0
    },
    label: {
      type: String,
      required: true
    },
    route: {
      type: String,
      default: 'admin.dashboard'
    }
  },
  computed: {
    hoverClass() {
      return `hover:${this.bgColor}`;
    },
    iconHoverClass() {
      return `group-hover:text-${this.bgColor.replace(/^bg-/, '')}`;
    }
  }
}
</script>
