import VueAxios from 'vue-axios';
import zipObject from 'lodash/zipObject';
import keys from 'lodash/keys';
import values from 'lodash/values';
import each from 'lodash/each';

function loadingDone(Vue) {
  if (Vue.router && Vue.router.app) {
    setTimeout(function () {
      Vue.router.app.$emit('loading-done');
    }, 200);
  }
}

export function resolve(resolves, next, component = null) {
  const resources = keys(resolves);

  return new Promise((resolve, reject) => {
    values(resolves)
      .reduce(function (promiseChain, currentTask) {
        return promiseChain.then((chainResults) => {
          return currentTask.apply(null, chainResults)
            .then((currentResult) => {
              return [ ...chainResults, currentResult ];
            });
        });
      }, Promise.resolve([]))
      .then((values) => {
        let setData = context => {
          each(values, (response, i) => {
            if (response !== null) {
              context[resources[i]] = response.data;
            }
          });

          if (typeof context.resolved == 'function') {
            context.resolved(zipObject(resources, values));
          }
        };

        if (component) {
          setData(component);
          next();
          resolve([component, values]);
        } else {
          next(vm => {
            setData(vm);
            resolve([vm, values]);
          });
        }
      })
  });
}

export let http;

export default {
  install(Vue, axios) {
    axios.defaults.baseURL = '/api/v1';
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    let token = document.head.querySelector('meta[name="csrf-token"]');

    // send the x-csrf-token, just incase
    if (token) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
      console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    // define Vue.axios required for vue-auth
    Vue.use(VueAxios, axios);

    // show loading when request starts
    axios.interceptors.request.use(config => {
      if (Vue.router && Vue.router.app) {
        Vue.router.app.$emit('loading-start');
      }

      return config;
    });

    // hide loading after request ends
    axios.interceptors.response.use(
      response => {
        loadingDone(Vue);
        return response;
      },
      error => {
        loadingDone(Vue);
        return Promise.reject(error);
      }
    );

    http = axios;
  }
}
