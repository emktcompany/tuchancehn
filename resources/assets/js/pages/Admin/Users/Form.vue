<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-2/3 flex flex-wrap">
        <form-field class="w-full px-2" name="name" label="Nombre">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <form-field class="md:w-1/2 w-full px-2" name="role" label="Rol">
          <choice-input id="role" v-model="row.data.role" v-validate="{required: true}" :options="roles" name="role" />
        </form-field>
        <form-field class="md:w-1/2 w-full px-2" name="is_active" label="Activo">
          <radio-group v-model="row.data.is_active" v-validate="{required: true}" :options="$yesNo" name="is_active" />
        </form-field>
      </div>
      <div class="lg:w-1/3 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="row.data.avatar_crop" :default="row.data.avatar"></image-cropper>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Credenciales</h2>
    <div class="-mx-2 flex flex-wrap">
      <form-field class="md:w-1/2 w-full px-2" name="email" label="Correo electrónico">
        <input type="email" name="email" v-validate="{required: true, email: true}" class="form-field text-sm" v-model="row.data.email">
      </form-field>
      <form-field class="md:w-1/2 w-full px-2" name="password" label="Contraseña">
        <password-input v-validate="{required: !$route.params.id, min: 8}" name="password" v-model="row.data.password" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Ubicación</h2>
    <div class="flex flex-wrap -mx-2">
      <form-field class="px-2 w-full lg:w-1/3" name="country_id" label="País">
        <country-select name="country_id" v-model="row.data.country_id" v-validate="{required: true}" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="state_id" label="Departamento">
        <state-select name="state_id" v-model="row.data.state_id" :country-id="row.data.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="city_id" label="Municipio">
        <city-select name="city_id" v-model="row.data.city_id" :state-id="row.data.state_id" />
      </form-field>
    </div>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import FormPage from '@/components/admin/FormPage.vue';

export default {
  extends: FormPage,
  data() {
    return {
      roles: [
        {value: 'admin', label: 'Administrador'},
      ]
    };
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.users.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          name: '',
          email: '',
          password: ''
        }
      };
    }
  }
}
</script>
