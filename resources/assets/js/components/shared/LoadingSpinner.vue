<template lang="html">
  <transition name="fade" :duration="{ enter: 150, leave: 150 }">
    <div v-if="loading" class="fixed pin bg-blue flex items-center justify-center opacity-50">
      <svg width="64" height="64" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#F05C5E">
        <g fill="none" fill-rule="evenodd">
          <g transform="translate(1 1)" stroke-width="2">
            <circle stroke-opacity=".25" cx="18" cy="18" r="18"></circle>
            <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(307.444 18 18)">
              <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.8s" repeatCount="indefinite"></animateTransform>
            </path>
          </g>
        </g>
      </svg>

    </div>
  </transition>
</template>

<script>
var started = 0, done = 0;

var checkDone = function() {
  var isDone = done >= started;
  return isDone;
}

export default {
  props: {
    mountOpen: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loading: this.mountOpen
    };
  },
  mounted() {
    if (this.mountOpen) {
      started++;
    }

    this.$root.$on('loading-start', this.show);
    this.$root.$on('loading-done', this.hide);
  },
  methods: {
    show() {
      started++;
      this.loading = true;
    },
    hide() {
      if (started) {
        done++;
      }

      if (started && checkDone()) {
        this.loading = false;
      }
    }
  }
}
</script>
