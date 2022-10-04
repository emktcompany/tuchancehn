<template lang="html">
  <span class="inline-flex items-center justify-center text-white rounded-full w-5 h-5 mr-2" v-tooltip.top-center="text" :class="pillClass">
    <span v-show="active">
      <svg-icon class="fill-current w-3 h-3 block" src="~@svg/icons/regular/check-square.svg"></svg-icon>
    </span>
    <span v-show="!active">
      <svg-icon class="fill-current w-3 h-3 block" src="~@svg/icons/regular/minus-square.svg"></svg-icon>
    </span>
  </span>
</template>

<script>
export default {
  props: {
    active: {
      type: Boolean,
      required: true
    },
    activeText: {
      type: String,
      default: 'Autorizado'
    },
    idleText: {
      type: String,
      default: 'Sin Autorizar'
    },
    activeClass: {
      type: String,
      default: 'bg-teal'
    },
    idleClass: {
      type: String,
      default: 'bg-red'
    }
  },
  computed: {
    text() {
      return !this.active ? this.idleText : this.activeText
    },
    pillClass() {
      return this.active ? this.activeClass : this.idleClass;
    }
  }
}
</script>
