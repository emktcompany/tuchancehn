<template lang="html">
  <div class="relative">
    <input class="naked-form-field" v-model="date" type="date" ref="flatpickr" @input="onInput">
    <div class="absolute flex h-full items-center pin-t pin-r pr-4" :class="focused ? 'text-purple' : 'text-grey'" v-if="valid">
      <svg-icon class="stroke-current fill-none" src="~@svg/calendar-icon.svg"></svg-icon>
    </div>
  </div>
</template>

<script>
import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";
export default {
  inject: ['$validator'],
  props: {
    options: {
      type: [Object, null],
      default: null
    },
    value: {
      require: true
    },
    name: {
      type: [String, null],
      default: null
    },
    enableTime: {
      type: Boolean,
      default: false
    },
    dateFormat: {
      type: String,
      default: 'Y-m-d'
    },
    altFormat: {
      type: String,
      default: 'j/F/Y'
    }
  },
  computed: {
    valid() {
      return this.name ? !this.errors.has(this.name) : true;
    },
    flatpickrOptions() {
      return Object.assign({
        onOpen: (selectedDates, dateStr, instance) => {
          this.focused = true;
          this.$emit('open');
        },
        onClose: (selectedDates, dateStr, instance) => {
          this.focused = false;
          this.$emit('close');
        },
        altInput: true,
        altFormat: this.altFormat + (this.enableTime ? ' H:i' : ''),
        dateFormat: this.dateFormat + (this.enableTime ? ' H:i' : ''),
        locale: Spanish
      }, this.options || {});
    }
  },
  data() {
    return {
      date: null,
      focused: false,
      pickr: null
    };
  },
  watch: {
    value(value, old) {
      this.parse()
    },
    flatpickrOptions() {
      if (this.pickr) {
        this.pickr.destroy();
      }
      this.mount();
    }
  },
  mounted() {
    this.mount();
  },
  methods: {
    parse() {
      var newVal = this.value ? this.$dayjs(this.value).toDate() : null;
      this.pickr.setDate(newVal, true);
      this.$emit('input', this.value ? this.$dayjs(this.value).format('YYYY-MM-DD') : null);
    },
    onInput($event) {
      this.$emit('input', $event.target.value);
    },
    mount() {
      this.pickr = flatpickr(this.$refs.flatpickr, this.flatpickrOptions);
      this.parse();
    }
  }
}
</script>
