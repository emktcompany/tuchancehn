<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">La Categoría</h2>
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-2/3 flex flex-wrap">
        <form-field class="w-full px-2" name="name" label="Nombre">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <form-field class="w-full px-2" name="is_active" label="Publicado">
          <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
        </form-field>
        <form-field class="w-full px-2" name="color" label="Color de Fondo">
          <div class="radio-group">
            <label class="radio whitespace-no-wrap text-sm mr-3 flex-inline inline-flex items-center" v-for="(color, i) in colors" :key="i">
              <input type="radio" v-model="row.data.color" name="color" :value="color">
              <span class="ml-2 w-6 h-6 rounded-full inline-block" :class="`bg-${color}`"></span>
            </label>
          </div>
        </form-field>
      </div>
      <div class="lg:w-1/3 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-input v-model="row.data.image_attachment" :default="row.data.image || null"/>
        </div>
      </div>
    </div>
    <form-field name="link" label="Ingresa un enlace si existe uno">
      <input type="url" name="link" v-validate="{url: true}" class="form-field text-sm" v-model="row.data.link" placeholder="http://">
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Descripción</h2>
    <form-field name="title" label="Título">
      <input type="text" name="title" class="form-field text-sm" v-model="row.data.title">
    </form-field>
    <form-field name="description" label="Descripción">
      <textarea name="description" v-validate="{required: true}" class="form-field text-sm resize-none h-32 rounded-lg leading-loose" v-model="row.data.description"></textarea>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Imágenes adicionales</h2>
    <div class="flex flex-col lg:flex-row justify-center -mx-2">
      <div class="lg:w-1/3 px-2 mb-6 md:mb-0">
        <div class="text-center text-cyan font-dosis mb-2">Imagen de Banner</div>
        <image-cropper :ratio="3.6" v-model="row.data.banner_crop" :default="row.data.banner || null"/>
      </div>
      <div class="lg:w-1/3 px-2">
        <div class="text-center text-cyan font-dosis mb-2">Imagen por defecto para oportunidades</div>
        <image-cropper :ratio="1.75" v-model="row.data.opportunity_crop" :default="row.data.opportunity || null"/>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Subcategorías</h2>
    <v-draggable :options="{draggable:'.list-item'}" v-model="row.data.subcategories" class="rounded list-group">
      <div class="list-item bg-white flex hover:shadow cursor-move" v-for="(category, i) in row.data.subcategories">
        <div class="flex items-center pl-3">
          <svg-icon src="~@svg/icons/solid/grip-lines.svg" class="fill-current w-4 h-4" />
        </div>
        <div class="flex-1 pl-3">
          <form-field :name="`subcategory_${i}_name`" label="Nómbre">
            <input type="text" :name="`subcategory_${i}_name`" class="form-field text-sm" v-model="row.data.subcategories[i].name">
          </form-field>
        </div>
        <div class="flex items-center px-3">
          <confirm-button @confirmed="removeCategory(i)"/>
        </div>
      </div>
      <a href slot="footer" class="rounded-b rounded-t-none block w-full btn bg-cyan text-white text-sm" @click.prevent="addSubcategory">Añadir sub categoría</a>
    </v-draggable>
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
      colors: ['blue', 'teal', 'orange', 'purple', 'red', 'cyan']
    };
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.categories.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          name: '',
          link: null,
          subcategories: []
        }
      };
    },
    addSubcategory() {
      this.row.data.subcategories.push({name: ''});
    },
    removeCategory(i) {
      this.row.data.subcategories.splice(i, 1);
    }
  }
}
</script>
