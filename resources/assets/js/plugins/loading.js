import LoadingSpinner from '@/components/shared/LoadingSpinner.vue';

export default {
  install(Vue) {
    Vue.component('loading-spinner', LoadingSpinner)

    Object.defineProperty(Vue.prototype, '$loading', {
      get() {
        return () => {
          this.$root.$emit('loading-start');
        };
      }
    });

    Object.defineProperty(Vue.prototype, '$loadingDone', {
      get() {
        return () => {
          this.$root.$emit('loading-done');
        };
      }
    });
  }
}
