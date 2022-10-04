<template lang="html">
  <div class="radio-group">
    <label class="radio whitespace-no-wrap" :class="labelClass" v-for="(option, i) in options" :key="i">
      <input type="radio" v-model="selected" :name="name" :value="option.value">
      {{ option.label }}
    </label>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    labelClass: {
      type: String,
      default: 'text-sm mr-3'
    },
    options: {
      type: Array,
      default: []
    },
    value: {
      default: null
    }
  },
  data() {
    return {
      selected: null
    }
  },
  created() {
    this.selected = this.value;
  },
  watch: {
    selected(value) {
      if (value != this.value) {
        this.$emit('input', value);
      }
    },
    value(value) {
      if (value != this.selected) {
        this.selected = value;
      }
    }
  },
  $_veeValidate: {
    value() {
      return this.selected;
    }
  }
}
</script>
