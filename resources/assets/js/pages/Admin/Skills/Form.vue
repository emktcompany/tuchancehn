<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <form-field name="name" label="Nombre">
      <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
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
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.skills.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          name: ''
        }
      };
    }
  }
}
</script>
