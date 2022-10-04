<template lang="html">
  <button type="button"
    :class="padding"
    class="outline-none focus:outline-none block appearance-none"
    @click.prevent="onClick"
    v-click-outside="onBlur"
    v-tooltip.top-center="text">
    <span v-show="!confirm" :class="idleClass">
      <svg-icon :class="iconSize" class="fill-current" src="~@svg/icons/regular/trash-alt.svg"></svg-icon>
    </span>
    <span v-show="confirm" :class="confirmClass">
      <svg-icon :class="iconSize" class="fill-current" src="~@svg/icons/regular/question-circle.svg"></svg-icon>
    </span>
  </button>
</template>

<script>
export default {
  props: {
    iconSize: {
      type: String,
      default: 'w-4 h-4'
    },
    padding: {
      type: String,
      default: 'p-2'
    },
    idleClass: {
      type: String,
      default: 'text-purple'
    },
    confirmClass: {
      type: String,
      default: 'text-red'
    }
  },
  data() {
    return {
      confirm: false
    }
  },
  computed: {
    text() {
      return !this.confirm ? 'Borrar' : 'Click para confirmar'
    }
  },
  methods: {
    onClick() {
      if (!this.confirm) {
        this.confirm = true;
      } else {
        this.confirm = false;
        this.$emit('confirmed');
      }
    },
    onBlur() {
      this.confirm = false;
    }
  }
}
</script>
