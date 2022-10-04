<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-2/3 flex flex-wrap">
        <form-field class="w-full px-2" name="name" label="Nombre">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <form-field class="w-full px-2" name="is_active" label="Publicado">
          <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
        </form-field>
      </div>
      <div class="md:w-1/3 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="row.data.image_crop" :default="row.data.image || null"/>
        </div>
      </div>
    </div>
    <form-field name="body" label="Descripción">
      <wysiwyg class="bg-white" v-model="row.data.body" v-validate="{required: true}" name="body" />
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
        name: 'admin.testimonials.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          name: '',
          body: ''
        }
      };
    }
  }
}
</script>
