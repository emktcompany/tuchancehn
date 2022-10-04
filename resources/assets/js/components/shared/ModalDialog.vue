<template lang="html">
  <transition name="modal">
    <div v-if="shown" class="fixed pin z-50 bg-smoke overflow-auto">
      <div class="relative h-full flex items-center justify-center py-12 px-4 sm:px-8">
        <div class="absolute pin cursor-pointer" @click="close"></div>
        <div class="w-full mx-auto shadow-lg max-h-full relative overflow-auto" :class="[width, theme, padding]">
          <div class="absolute pin-t pin-x">
            <div class="container px-0 text-right">
              <a href @click.prevent="close" class="p-3 no-underline inline-block" :class="arrowColor">
                <svg-icon src="~@svg/close-icon.svg" class="stroke-current sm:w-3 sm:h-3 w-2 h-2"></svg-icon>
              </a>
            </div>
          </div>
          <slot></slot>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>

export default {
  props: {
    shown: {
      type: Boolean,
      required: true
    },
    padding: {
      type: String,
      default: 'p-4 sm:p-8'
    },
    arrowColor: {
      type: String,
      default: 'text-black'
    },
    width: {
      type: String,
      default: 'max-w-lg'
    },
    theme: {
      type: String,
      default: 'bg-white text-grey-dark'
    }
  },
  methods: {
    close() {
      this.$emit('modal-close');
    }
  }
}
</script>
