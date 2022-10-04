<template lang="html">
  <div class="flex md:flex-row -mx-4">
    <form-field v-if="allowCountryChange" class="w-full md:w-1/3 px-4" name="country_id" label="País">
      <select name="country_id" v-validate="validateCountry" v-model="country_id" class="form-field" :class="country_id?'':'text-grey-dark'">
        <option :value="null">País</option>
        <option :value="country.id" v-for="country in $countries" :key="`country-${country.id}`">{{country.name}}</option>
      </select>
    </form-field>
    <form-field class="w-full md:w-1/3 px-4" name="state_id" label="Departamento">
      <select name="state_id" v-model="state_id" class="form-field" :class="state_id?'':'text-grey-dark'">
        <option :value="null">Departamento</option>
        <option :value="state.id" v-for="state in country.states" :key="`state-${state.id}`">{{state.name}}</option>
      </select>
    </form-field>
    <form-field class="w-full md:w-1/3 px-4" name="city_id" label="Ciudad">
      <select name="city_id" v-model="city_id" class="form-field" :class="city_id?'':'text-grey-dark'">
        <option :value="null">Ciudad</option>
        <option :value="city.id" v-for="city in state.cities" :key="`city-${city.id}`">{{city.name}}</option>
      </select>
    </form-field>
  </div>
</template>

<script>
import find from 'lodash/find';
import HasLocations from '@/mixins/HasLocations';

export default {
  mixins: [HasLocations],
  props: {
    allowCountryChange: {
      type: Boolean,
      default: false
    },
    value: {
      type: Object,
      required: true
    },
    validateCountry: {
      type: Object,
      default: () => {required: true}
    },
    validateState: {
      type: Object,
      default: () => {}
    },
    validateCity: {
      type: Object,
      default: () => {}
    }
  },
  inject: ['$validator'],
  data() {
    return {
      country_id: null,
      city_id: null,
      state_id: null,
    }
  },
  watch: {
    value(value) {
      this.parse();
    },
    country_id(value) {
      if (value && this.value.country_id != value) {
        this.update();
      }
    },
    state_id(value) {
      if (value && this.value.state_id != value) {
        this.update();
      }
    },
    city_id(value) {
      if (value && this.value.city_id != value) {
        this.update();
      }
    },
  },
  created() {
    this.parse();
  },
  methods: {
    parse() {
      if (this.value && this.country_id != this.value.country_id) {
        this.country_id = this.value.country_id;
      }
      if (this.value && this.state_id != this.value.state_id) {
        this.state_id = this.value.state_id;
      }
      if (this.value && this.city_id != this.value.city_id) {
        this.city_id = this.value.city_id;
      }
    },
    update() {
      var newValue = Object.assign({}, this.value, {
        country_id: this.country_id,
        state_id: this.state_id,
        city_id: this.city_id
      });
      this.$emit('input', newValue);
    }
  }
}
</script>
