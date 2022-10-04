<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Información personal</h2>
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-5/6 flex flex-wrap">
        <form-field class="w-full md:w-3/5 px-2" name="name" label="Nombre completo">
          <input type="text" name="name" v-validate="rules.name" class="form-field text-sm" v-model="data.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="email" label="Correo electrónico">
          <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
        </form-field>
      </div>
    </div>
    <div class="flex flex-wrap -mx-2">
      <form-field class="px-2 w-full md:w-1/3" name="country_id" label="País">
        <country-select name="country_id" v-model="data.country_id" v-validate="{required: true}" />
      </form-field>
      <form-field class="px-2 w-full md:w-1/3" name="state_id" label="Departamento">
        <state-select name="state_id" v-model="data.state_id" :country-id="data.country_id" />
      </form-field>
      <form-field class="px-2 w-full md:w-1/3" name="city_id" label="Municipio">
        <city-select name="city_id" v-model="data.city_id" :state-id="data.state_id" />
      </form-field>
    </div>
    <div class="text-center mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import find from 'lodash/find';
import FocusesOnError from '@/mixins/FocusesOnError';
export default {
  mixins: [FocusesOnError],
  data() {
    return {
      data: {},
      rules: {
        name: {required: true},
        email: {required: true, email: true},
        password: {},
      }
    };
  },
  created() {
    this.data = this.$user;
  },
  computed: {
    country() {
      var id = this.data.country_id || null;
      return find(this.$countries, {id}) || {states: []};
    },
    state() {
      var id = this.data.state_id || null;
      return find(this.country.states, {id}) || {cities: []};
    }
  },
  methods: {
    async submit() {
      var valid = await this.$validator.validate();

      if (valid) {
        try {
          var response = await this.$http.put('account/admin', this.data);
          this.$auth.fetch();
          this.$notify({
            title: 'Éxito',
            text: 'Cuenta actualizada',
            type: 'success'
          });
        } catch (e) {
        }
      } else {
        this.focusOnError();
      }
    }
  }
}
</script>
