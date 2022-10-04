import NotificationCenter from '@/components/shared/NotificationCenter.vue';

export default {
  install(Vue) {
    Vue.component('notification-center', NotificationCenter)

    Object.defineProperty(Vue.prototype, '$notify', {
      get() {
        var vm = this.$root;
        return (params) => {
          if (typeof params === 'string') {
            params = { title: '', text: params, type: 'success' }
          }

          if (typeof params === 'object') {
            vm.$emit('notify', params)
          }
        };
      }
    });
  }
}
