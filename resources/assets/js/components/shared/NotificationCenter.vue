<template lang="html">
  <div class="fixed pin-b pin-l overflow-hidden alert-holder cursor-pointer" :style="holderStyles">
    <transition
      @after-leave="notifying=false"
      enter-active-class="animated zoomIn"
      leave-active-class="animated zoomOut">
      <div v-if="show" class="absolute rounded-full alert flex items-start justify-end" :class="bgClass" @click="hide">
        <div class="flex flex-col items-start justify-end text-white alert-inner p-12">
          <div class="mb-8 text-white">
            <svg-icon class="fill-none stroke-current" v-if="type == 'error'" src="~@svg/alert-error-icon.svg"></svg-icon>
            <svg-icon class="fill-none stroke-current" v-if="type == 'warning'" src="~@svg/alert-warning-icon.svg"></svg-icon>
            <svg-icon class="fill-none stroke-current" v-if="type == 'info'" src="~@svg/alert-info-icon.svg"></svg-icon>
            <svg-icon class="fill-none stroke-current" v-if="type == 'success'" src="~@svg/alert-success-icon.svg"></svg-icon>
          </div>
          <div class="mb-4 font-dosis font-bold text-lg" v-if="title">{{ title }}</div>
          <div class="text-sm" v-if="text">{{ text }}</div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      notifying: false,
      show: false,
      type: null,
      title: null,
      text: null,
      timeout: null
    };
  },
  mounted() {
    this.$root.$on('notify', this.notify);
  },
  computed: {
    holderStyles() {
      if (this.notifying) {
        return {width: '300px', height: '300px'};
      }

      return {};
    },
    bgClass() {
      switch (this.type) {
        case 'success':
          return 'bg-teal';
          break;
        case 'error':
          return 'bg-red';
          break;
        case 'warning':
          return 'bg-orange';
          break;
      }
      return 'bg-cyan';
    }
  },
  methods: {
    notify(params) {
      this.notifying = true;
      this.show = true;
      this.title = params.title || null;
      this.type = params.type || 'info';
      this.text = params.text || null;

      clearTimeout(this.timeout);

      this.timeout = setTimeout(this.hide, 5000);
    },
    hide() {
      clearTimeout(this.timeout);
      this.show = false;
    }
  }
}
</script>

<style lang="scss" scoped>
  .alert {
    width: 600px;
    height: 600px;
    margin-left: -300px;
    margin-bottom: -300px;
    animation-duration: .25s;
    transition: background-color .25s ease;
  }

  .alert-inner {
    width: 300px;
    height: 300px;
  }
</style>
