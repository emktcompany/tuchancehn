<template lang="html">
  <button type="button"
    class="outline-none focus:outline-none p-2 block appearance-none"
    @click.prevent="onClick"
    v-click-outside="onBlur"
    v-tooltip.top-center="text">
    <span v-show="!active && !confirm" class="text-teal">
      <slot name="icon-idle"><svg-icon class="fill-current w-4 h-4" src="~@svg/icons/regular/check-square.svg"></svg-icon></slot>
    </span>
    <span v-show="active && !confirm" class="text-red">
      <slot name="icon-active"><svg-icon class="fill-current w-4 h-4" src="~@svg/icons/regular/minus-square.svg"></svg-icon></slot>
    </span>
    <span v-show="confirm" class="text-orange">
      <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/regular/question-circle.svg"></svg-icon>
    </span>
  </button>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      required: true
    },
    active: {
      type: Boolean,
      required: true
    },
    prop: {
      type: String,
      default: 'is_active'
    },
    activeText: {
      type: String,
      default: 'Revocar Acceso'
    },
    idleText: {
      type: String,
      default: 'Activar'
    },
  },
  data() {
    return {
      confirm: false
    }
  },
  computed: {
    text() {
      if (this.confirm) {
        return 'Click para confirmar';
      }

      return !this.active ? this.idleText : this.activeText
    }
  },
  methods: {
    async onClick() {
      if (this.confirm) {
        var response = await this.$http.post(this.url);
        this.$emit('toggled', !this.active);
        this.confirm = false;
      } else {
        this.confirm = true;
      }
    },
    onBlur() {
      this.confirm = false;
    }
  }
}
</script>
