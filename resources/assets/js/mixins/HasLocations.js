import find from 'lodash/find';

export default {
  computed: {
    country() {
      var id = this.locationContext.country_id || null;
      return find(this.$countries, {id}) || {states: []};
    },
    state() {
      var id = this.locationContext.state_id || null;
      return find(this.country.states, {id}) || {cities: []};
    },
    city() {
      var id = this.locationContext.city_id || null;
      return find(this.state.cities, {id}) || {};
    },
    locationContext() {
      return this;
    }
  }
}
