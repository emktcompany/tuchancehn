import {getScript} from '@/lib/utils';

let auth2;

export default {
  install(Vue, client_id) {
    getScript('https://apis.google.com/js/client:platform.js', () => {
      gapi.load('auth2', function() {
        auth2 = gapi.auth2.init({client_id});
      });
    });

    Object.defineProperty(Vue.prototype, '$gapi', {
      get() {
        return gapi || undefined;
      }
    });

    Object.defineProperty(Vue.prototype, '$auth2', {
      get() {
        return auth2 || undefined;
      }
    });
  }
}
