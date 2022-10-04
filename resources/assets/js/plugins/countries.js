import find from 'lodash/find';
import filter from 'lodash/filter';

export default {
  install(Vue) {
    Object.defineProperty(Vue.prototype, '$countries', {
      get() {
        return this.$root.countries;
      }
    });

    Object.defineProperty(Vue.prototype, '$country', {
      get() {
        return this.$root.country;
      }
    });

    Object.defineProperty(Vue.prototype, '$allCountries', {
      get() {
        return this.$root.allCountries;
      }
    });

    Vue.filter('location', function (row) {
      var country = row.country || {};
      var state   = row.state || {};
      var city    = row.city || {};

      return filter([
        country.name,
        state.name,
        city.name,
      ]).join(' &bull; ')
    });
  }
}

export let defaultCountry;

export let HasCountries = {
  data() {
    return {
      allCountries: [],
      countries: [],
      country: null
    };
  },
  async created() {
    var response = await this.$http.get('/locations');
    this.countries = response.data.data;
    defaultCountry = response.data.meta.default;
    this.setCountry(defaultCountry);
  },
  methods: {
    setCountry(code) {
      let country = find(this.countries, {code});

      if (!country) {
        code    = defaultCountry;
        country = find(this.countries, {code});
      }

      this.country = country;
      window.localStorage.setItem('country', code);
    },
    async getAllCountries() {
      if (this.allCountries.length == 0) {
        var response      = await this.$http.get('/locations/countries');
        this.allCountries = response.data.data;
      }

      return Promise.resolve(this.allCountries);
    }
  }
};
