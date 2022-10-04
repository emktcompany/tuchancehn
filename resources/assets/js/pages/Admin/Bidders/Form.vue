<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Información personal</h2>
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-5/6 flex flex-wrap">
        <form-field class="w-full md:w-3/5 px-2" name="name" label="Nombre completo de Contacto">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.user.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="email" label="Correo electrónico">
          <input type="email" name="email" v-validate="{required: true, email: true}" class="form-field text-sm" v-model="row.data.user.email">
        </form-field>
        <form-field class="w-full md:w-3/5 px-2" name="bidder_name" label="Nombre de Oferente">
          <input type="text" name="bidder_name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="web" label="Sitio Web">
          <input type="url" name="web" v-validate="{url: true}" class="form-field text-sm" v-model="row.data.web" placeholder="http://">
        </form-field>
        <div class="w-full flex flex-wrap">
          <form-field class="w-full sm:w-3/5 px-2" name="phone" label="Teléfono">
            <tel-input :country="country" class="form-field" name="phone" v-validate="{numeric: true}" v-model="row.data.phone" />
          </form-field>
          <form-field class="w-full sm:w-2/5 px-2" name="cell_phone" label="Teléfono Celular">
            <tel-input :country="country" class="form-field" name="cell_phone" v-validate="{numeric: true}" v-model="row.data.cell_phone" />
          </form-field>
        </div>
      </div>
      <div class="lg:w-1/6 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="row.data.avatar_crop" :default="row.data.user.avatar || null"/>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Oferente</h2>
    <div class="-mx-2">
      <form-field class="w-full px-2" name="summary" label="Resumen">
        <textarea name="summary" maxlength="140" v-validate="{required: true, max: 140}" class="form-field text-sm resize-none h-32 rounded-lg leading-loose" v-model="row.data.summary"></textarea>
        <remaining-count class="text-sm text-right mt-2" :length="(row.data.summary||'').length" :max="140" />
      </form-field>
      <form-field class="w-full px-2" name="services" label="Servicios">
        <wysiwyg class="bg-white" v-model="row.data.services" name="services" />
      </form-field>
      <form-field class="w-full px-2" name="description" label="Descripción">
        <wysiwyg class="bg-white" v-model="row.data.description" name="description" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Ubicación</h2>
    <div class="flex flex-wrap -mx-2">
      <form-field class="px-2 w-full lg:w-1/3" name="country_id" label="País">
        <country-select v-validate="{required: true}" @change="onCountryChange" name="country_id" v-model="row.data.user.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="state_id" label="Departamento">
        <state-select name="state_id" v-model="row.data.user.state_id" :country-id="row.data.user.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="city_id" label="Municipio">
        <city-select name="city_id" v-model="row.data.user.city_id" :state-id="row.data.user.state_id" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">¿En qué categoría publicará más oportunidades?</h2>
    <form-field class="w-full" name="categories" label="Selecciona una categoría">
      <v-select label="name" :options="$categories" class="form-field" v-model="category" @input="row.data.category_id=(category?category.id:null)" name="category_id">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">¿A qué industria perteneces?</h2>
    <form-field class="w-full" name="categories" label="Selecciona una industria">
      <v-select label="name" :options="interests" class="form-field" v-model="interest" @input="row.data.interest_id=(interest?interest.id:null)" name="interest_id">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Configuración de la cuenta</h2>
    <div class="flex flex-col md:flex-row -mx-2">
      <form-field class="w-full lg:w-1/3 px-2" name="password" label="Contraseña">
        <password-input v-validate="{required: !$route.params.id, min: 8}" name="password" v-model="row.data.user.password" />
      </form-field>
      <form-field class="w-full lg:w-1/3 px-2" name="is_active" label="Activo">
        <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
      </form-field>
      <form-field class="w-full lg:w-1/3 px-2" name="is_featured" label="Destacado en Home">
        <radio-group v-model="row.data.is_featured" name="is_featured" v-validate="{required: true}" :options="$yesNo" />
      </form-field>
    </div>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import find from 'lodash/find';
import FormPage from '@/components/admin/FormPage.vue';

var row = {
  user: {
    avatar: "",
    name: '',
    password: '',
    email: ''
  },
  web: "",
  phone: "",
  cell_phone: "",
  summary: "",
  services: "",
  description: "",
  category_ids: []
};

export default {
  extends: FormPage,
  data() {
    return {
      category: null,
      interest: null,
      interests: [],
      country: null,
      row: {data: Object.assign({}, row)}
    };
  },
  async created() {
    var response = await this.$http.get('interests');
    this.interests = response.data.data;

    if (this.row.data.category_id) {
      this.category = find(this.$categories, {id: this.row.data.category_id});
    }

    if (this.row.data.interest_id) {
      this.interest = find(this.interests, {id: this.row.data.interest_id});
    }
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.bidders.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: Object.assign({}, row)
      };
    },
    onCountryChange(country) {
      this.country = country;
    }
  }
}
</script>
