<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Configuración de la cuenta</h2>
    <div class="flex flex-col md:flex-row -mx-2">
      <form-field class="w-full md:w-1/2 px-2" name="password" label="Contraseña">
        <password-input v-validate="rules.password" name="password" v-model="data.password" />
      </form-field>
      <div class="flex flex-wrap w-full md:w-1/2">
        <form-field class="w-full md:w-2/5 px-2" name="privacy" label="Privacidad de perfil">
          <radio-group class="py-2" v-model="data.candidate.privacy" name="privacy" v-validate="rules.privacy" :options="$privacy" />
        </form-field>
        <form-field class="w-full md:w-3/5 px-2" name="subscription" label="Notificaciones por correo y SMS">
          <radio-group class="py-2" v-model="data.candidate.subscription" name="subscription" v-validate="rules.subscription" :options="$yesNo" />
        </form-field>
      </div>
    </div>
    <div class="flex flex-col md:flex-row -mx-2">
      <form-field class="w-full md:w-1/2 px-2" name="candidate_id_type" label="Tipo de identificación">
        <select name="candidate_id_type" v-model="data.candidate.id_type" class="form-field">
          <option :value="null">Ninguno</option>
          <option :value="i" v-for="i in idTypes">{{i}}</option>
        </select>
      </form-field>
      <form-field class="w-full md:w-1/2 px-2" name="candidate_id_number" label="Número de identificación">
        <input type="tel" name="candidate_id_number" class="form-field text-sm" v-model="data.candidate.id_number">
      </form-field>
    </div>
    <form-field class="w-full" :error="null" label="Intereses">
      <label class="whitespace-no-wrap inline-block mb-2 radio text-sm mr-3" v-for="category in interests">
        <input type="checkbox" :id="`interest-${category.id}`" :value="category.id" v-model="data.tag_ids">
        {{category.name}}
      </label>
    </form-field>
    <div class="text-center mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import {objectToFormData} from '@/lib/formData';
import FocusesOnError from '@/mixins/FocusesOnError';

export default {
  mixins: [FocusesOnError],
  data() {
    return {
      rules: {
        password: {}
      },
      data: {candidate: {skills: []}, tag_ids: []},
      avatar_cropper: null,
      avatar: null,
      interests: [],
      idTypes: ['Cédula', 'Pasaporte', 'Otro']
    };
  },
  async created() {
    this.data      = this.$user;
    var response   = await this.$http.get('interests');
    this.interests = response.data.data;
  },
  methods: {
    async submit() {
      var valid = await this.$validator.validate();
      var form_data;

      if (valid) {
        this.data.candidate.birth = this.$dayjs(this.data.candidate.birth)
          .format('YYYY-MM-DD');

        form_data = objectToFormData(this.data);
        form_data.append('_method', 'put');

        try {
          var response = await this.$http.post('account/candidate', form_data);
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
