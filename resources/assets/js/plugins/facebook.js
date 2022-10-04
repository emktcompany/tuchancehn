import {getScript} from '@/lib/utils';

export default {
  install(Vue, client_id) {
    getScript('https://connect.facebook.net/en_US/sdk.js', () => {
      FB.init({
        appId: client_id,
        cookie: true,
        version: 'v2.2'
      });
    });

    Object.defineProperty(Vue.prototype, '$FB', {
      get() {
        return FB || undefined;
      }
    });
  }
}
