import VueAuth from '@websanova/vue-auth';

export default {
  install(Vue) {
    Vue.use(VueAuth, {
        auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
        http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
        router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
        notFoundRedirect: {path: '/404'},
        forbiddenRedirect: {path: '/403'},
        authRedirect: {path: '/cunta/login'},
        fetchData: {url: 'account/me', method: 'GET', enabled: true},
        refreshData: {url: 'auth/refresh', method: 'POST', enabled: true, interval: 30},
        parseUserData: function (data) {
          return data.data;
        }
    });

    Object.defineProperty(Vue.prototype, '$loggedIn', {
      get() {
        return this.$auth.check();
      }
    });

    Object.defineProperty(Vue.prototype, '$guest', {
      get() {
        return !this.$auth.check();
      }
    });

    Object.defineProperty(Vue.prototype, '$authReady', {
      get() {
        return this.$auth.ready();
      }
    });

    Object.defineProperty(Vue.prototype, '$user', {
      get() {
        return this.$auth.user();
      }
    });
  }
}
