<template lang="html">
  <svg xmlns="http://www.w3.org/2000/svg"
    :width="svgWidth"
    :height="svgHeight"
    :viewBox="viewbox"
    role="presentation"
    v-html="content"
  ></svg>
</template>

<script>
export default {
  props: {
    src: {
      type: String,
      required: false
    },
    width: {
      type: [Number, String],
      default: 0
    },
    height: {
      type: [Number, String],
      default: 0
    },
    source: {
      type: String,
      default: ''
    }
  },
  computed: {
    svg() {
      var div = document.createElement('div');
      div.innerHTML = this.src ? this.src : this.source;
      return div.firstChild;
    },
    content() {
      return this.svg.innerHTML;
    },
    svgWidth() {
      return this.width ? this.width : this.svg.getAttribute('width');
    },
    svgHeight() {
      return this.height ? this.height : this.svg.getAttribute('height');
    },
    viewbox() {
      return this.svg.getAttribute('viewbox') || this.svg.getAttribute('viewBox');
    }
  }
}
</script>
