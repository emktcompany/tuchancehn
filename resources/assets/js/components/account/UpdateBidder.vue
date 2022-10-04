<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Información personal</h2>
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-5/6 flex flex-wrap">
        <form-field class="w-full md:w-3/5 px-2" name="name" label="Nombre completo de Contacto">
          <input type="text" name="name" v-validate="rules.name" class="form-field text-sm" v-model="data.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="email" label="Correo electrónico">
          <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
        </form-field>
        <form-field class="w-full md:w-3/5 px-2" name="bidder_name" label="Nombre de Oferente">
          <input type="text" name="bidder_name" v-validate="rules.name" class="form-field text-sm" v-model="data.bidder.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="web" label="Sitio Web">
          <input type="url" name="web" v-validate="rules.web" class="form-field text-sm" v-model="data.bidder.web" placeholder="http://">
        </form-field>
        <div class="w-full md:w-3/5 flex flex-wrap">
          <form-field class="w-full sm:w-1/2 px-2" name="phone" label="Teléfono">
            <tel-input :country="country" class="form-field" name="phone" v-validate="rules.phone" v-model="data.bidder.phone" />
          </form-field>
          <form-field class="w-full sm:w-1/2 px-2" name="cell_phone" label="Teléfono Celular">
            <tel-input :country="country" class="form-field" name="cell_phone" v-validate="rules.phone" v-model="data.bidder.cell_phone" />
          </form-field>
        </div>
      </div>
      <div class="md:w-1/6 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="data.avatar_crop" :default="data.avatar || null"/>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Oferente</h2>
    <div class="-mx-2">
      <form-field class="w-full px-2" name="summary" label="Resumen">
        <textarea class="form-field text-sm resize-none h-32 rounded-lg leading-loose" maxlength="140" v-model="data.bidder.summary" v-validate="{required: true, max: 140}" name="summary" ></textarea>
        <remaining-count class="text-sm text-right mt-2" :length="(data.bidder.summary || '').length" :max="140" />
      </form-field>
      <form-field class="w-full px-2" name="services" label="Servicios">
        <wysiwyg class="bg-white" v-model="data.bidder.services" v-validate="rules.services" name="services" />
      </form-field>
      <form-field class="w-full px-2" name="description" label="Descripción">
        <wysiwyg class="bg-white" v-model="data.bidder.description" v-validate="rules.description" name="description" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">¿En qué categoría planeas publicar más oportunidades?</h2>
    <form-field class="w-full" name="categories" label="Selecciona una categoría">
      <v-select label="name" :options="$categories" class="form-field" v-model="category" @input="data.bidder.category_id=(category?category.id:null)" v-validate="rules.categories" name="category_id">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">¿A qué industria perteneces?</h2>
    <form-field class="w-full" name="categories" label="Selecciona una categorías">
      <v-select label="name" :options="interests" class="form-field" v-model="interest" @input="data.bidder.interest_id=(interest?interest.id:null)" name="interest_id">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Ubicación</h2>
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
import {objectToFormData} from '@/lib/formData';
import FocusesOnError from '@/mixins/FocusesOnError';
export default {
  mixins: [FocusesOnError],
  data() {
    return {
      rules: {
        name: {required: true},
        email: {required: true, email: true},
        password: {},
        phone: {required: true, digits: 8},
        web: {url: true},
        services: {required: true},
        state_id: {required: true},
        city_id: {required: true},
        country_id: {required: true},
      },
      data: {candidate: {}, tag_ids: []},
      interest: null,
      category: null,
      avatar_cropper: null,
      avatar: null
    };
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
  created() {
    this.data     = this.$user;
    this.category = find(this.$categories, {
      id: this.$user.bidder.category_id
    });
    this.avatar   = this.data.avatar && this.data.avatar.url;
  },
  methods: {
    async submit() {
      var valid = await this.$validator.validate();
      var form_data;

      if (valid) {
        form_data = objectToFormData(this.data);
        form_data.append('_method', 'put');

        try {
          var response = await this.$http.post('account/bidder', form_data);
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
