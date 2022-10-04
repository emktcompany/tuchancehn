<template lang="html">
  <div class="form-group pb-4">
    <label :class="labelClass" class="form-label">{{ label }}</label>
    <div class="relative" :class="fieldContainerClass">
      <slot></slot>
      <div v-if="error" class="absolute flex h-full items-center pin-t pin-r pr-4 text-red">
        <svg-icon class="fill-none stroke-current" src="~@svg/error-icon.svg"></svg-icon>
      </div>
    </div>
    <span class="text-red text-xs italic font-ligther absolute pin-r pin-b block mr-4" v-if="error">{{ error }}</span>
  </div>
</template>

<script>
export default {
  inject: ['$validator'],
  props: {
    label: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: false,
      default: ''
    },
    labelClass: {
      type: String,
      required: false,
      default: ''
    },
    fieldContainerClass: {
      type: String,
      required: false,
      default: ''
    },
  },
  computed: {
    error() {
      return this.name ? this.errors.first(this.name) : false;
    }
  }
}
</script>
