<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-2/3 flex flex-wrap px-2">
        <form-field class="w-full" name="name" label="Nombre">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <form-field class="w-full" name="text" label="Hashtag">
          <input type="text" name="text" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.text">
        </form-field>
      </div>
      <div class="lg:w-1/3 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper :ratio="1.8" v-model="row.data.image_crop" :default="row.data.image || null"/>
        </div>
      </div>
    </div>
    <form-field name="is_active" label="Publicado">
      <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
    </form-field>
    <form-field name="type" label="Tipo">
      <choice-input id="type" class="form-field" v-model="row.data.type" v-validate="{required: true}" :options="types" name="type" :empty="true" value-key="id" label-key="name" />
    </form-field>
    <form-field name="link" label="Ingresa un enlace">
      <input type="url" name="link" v-validate="{url: true}" class="form-field text-sm" v-model="row.data.link" placeholder="http://">
    </form-field>
    <form-field name="link_text" label="Ingresa el texto del enlace">
      <input type="text" name="link_text" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.link_text">
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
        {id: 1, name: 'Home Regular'},
        {id: 2, name: 'Home Usuario'},
        {id: 3, name: 'Home Oferente'},
      ]
    };
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.banners.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          name: '',
          text: '',
          link: '',
          link_text: ''
        }
      };
    }
  }
}
</script>
