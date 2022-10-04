<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <form-field name="file" label="Selecciona un archivo">
      <file-input v-model="file" v-validate="{required: true}" name="file" />
    </form-field>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Importar</button>
    </div>
  </form>
</template>

<script>
import {objectToFormData} from '@/lib/formData';
export default {
  props: {
    action: {
      type: String,
      require: true
    }
  },
  data () {
    return {
      file: null
    };
  },
  methods: {
    async send() {
      var form_data = objectToFormData({file: this.file});

      try {
        var response = await this.$http.post(this.action, form_data);
        this.file    = null;
        this.$notify({
          'text': 'Importado con éxito',
          'type': 'success'
        });
      } catch (e) {
        this.$notify({
          'text': e.response.data.message,
          'type': 'error'
        });
      }
    },
    async validate() {
      var valid = await this.$validator.validate();

      if (valid) {
        return await this.send();
      }

      throw Error('invalid');
    },
    async submit() {
      return await this.validate();
    }
  }
}
</script>
