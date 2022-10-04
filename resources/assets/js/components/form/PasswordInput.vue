<template lang="html">
  <div class="relative">
    <input :type="type" autocomplete="off" :name="name" class="form-field text-sm" v-bind:value="value" @input="$emit('input', $event.target.value)">
    <div class="absolute flex h-full items-center pin-t pin-r pr-4 cursor-pointer" :class="shown ? 'text-purple' : 'text-grey'">
      <svg-icon v-if="valid" class="fill-none stroke-current" @click.native="togglePassword" src="~@svg/eye-icon.svg"></svg-icon>
    </div>
  </div>
</template>

<script>
  export default {
    inject: ['$validator'],
    props: {
      name: {
        type: String,
        default: ''
      },
      value: {
        required: false
      }
    },
    data() {
      return {
        shown: false
      };
    },
    methods: {
      togglePassword() {
        var input = this.$el.querySelector('input');

        if (input.getAttribute('type') === 'password') {
          this.shown = true;
          input.setAttribute('type', 'text');
          input.focus();
        } else {
          this.shown = false;
          input.setAttribute('type', 'password');
          input.focus();
        }
      }
    },
    computed: {
      valid() {
        return this.name ? !this.errors.has(this.name) : true;
      },
      type() {
        return this.shown ? 'text' : 'password';
      }
    }
  }
</script>
