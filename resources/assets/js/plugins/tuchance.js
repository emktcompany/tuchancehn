import map from 'lodash/map';

export default {
  install(Vue) {
    Object.defineProperty(Vue.prototype, '$categories', {
      get() {
        return this.$root.categories;
      }
    });

    Object.defineProperty(Vue.prototype, '$settings', {
      get() {
        return this.$root.settings;
      }
    });

    Object.defineProperty(Vue.prototype, '$colors', {
      get() {
        return require('@/colors');
      }
    });

    Object.defineProperty(Vue.prototype, '$genders', {
      get() {
        return require('@/data/genders.json');
      }
    });

    Object.defineProperty(Vue.prototype, '$yesNo', {
      get() {
        return require('@/data/yes-no.json');
      }
    });

    Object.defineProperty(Vue.prototype, '$privacy', {
      get() {
        return require('@/data/privacy.json');
      }
    });

    Vue.mixin({
      data() {
        return {
          isMounted: false
        };
      },
      mounted() {
        this.isMounted = true;
      }
    })
  }
}

export let HasCategories = {
  data() {
    return {
      categories: [],
      settings: [],
    };
  },
  created() {
    this.$http.get('/categories')
      .then((response) => {
        this.categories = map(response.data.data, (category) => {
          return category;
        });

        this.$emit('categories-loaded', this.categories);
      });

    this.$http.get('/settings')
      .then((response) => {
        this.settings = map(response.data.data, (category) => {
          return category;
        });

        this.$emit('settings-loaded', this.settings);
      });
  },
};
