<template lang="html">
  <span v-html="location"></span>
</template>

<script>
import find from 'lodash/find';
import filter from 'lodash/filter';

export default {
  props: {
    row: {
      type: Object,
      required: true
    }
  },
  computed: {
    location() {
      return filter([
        this.row.country ? this.row.country.name : null,
        this.row.state ? this.row.state.name : null,
        this.row.city ? this.row.city.name : null,
      ]).join(' &bull; ')
    }
  }
}
</script>
