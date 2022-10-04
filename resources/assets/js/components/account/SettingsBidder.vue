<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Configuración de la cuenta</h2>
    <div class="flex flex-col md:flex-row -mx-2">
      <form-field class="w-full md:w-1/2 px-2" name="password" label="Contraseña">
        <password-input v-validate="rules.password" name="password" v-model="data.password" />
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
        password: {},
      },
      interests: [],
      data: {bidder: {}, tag_ids: []}
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
