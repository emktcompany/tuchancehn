<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <form-field name="question" label="Pregunta">
      <input type="text" name="question" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.question">
    </form-field>
    <form-field name="answer" label="Respuesta">
      <wysiwyg class="bg-white" v-model="row.data.answer" v-validate="{required: true}" name="answer" />
    </form-field>
    <form-field name="type" label="Tipo">
      <choice-input id="type" v-model="row.data.type" v-validate="{required: true}" :options="types" name="type" value-key="id" label-key="name" />
    </form-field>
    <form-field name="is_active" label="Publicado">
      <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
    </form-field>
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
      types: [
        {id: 0, name: 'En home'},
        {id: 1, name: 'En página'},
      ]
    };
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.interests.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          question: '',
          answer: ''
        }
      };
    }
  }
}
</script>
