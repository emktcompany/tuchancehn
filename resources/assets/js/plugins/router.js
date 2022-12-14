import VueRouter from 'vue-router';
import routes from '../routes';

export default {
  install(Vue) {
    Vue.router = new VueRouter({
      mode: 'history',
      routes,
      scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 };
      }
    });

    Vue.use(VueRouter, Vue.router);
  }
}
