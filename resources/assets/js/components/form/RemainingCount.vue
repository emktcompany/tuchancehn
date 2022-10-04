<template lang="html">
  <div v-if="max > 0">
    <span :class="className">{{length}}</span> / {{max}}
  </div>
</template>

<script>
import find from 'lodash/find';

export default {
  props: {
    max: {
      type: Number,
      default: 0
    },
    length: {
      type: Number,
      default: 0
    }
  },
  computed: {
    remaining() {
      return this.max - this.length;
    },
    className() {
      var percentage = (this.length / this.max) * 100;

      if (percentage <= 75) {
        return 'text-teal';
      } else if (percentage <= 100) {
        return 'text-orange'
      }

      return 'text-red';
    }
  }
}
</script>
