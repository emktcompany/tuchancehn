<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">La Oportunidad</h2>
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-2/3 flex flex-wrap">
        <form-field class="w-full px-2" name="name" label="Nombre">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.name">
        </form-field>
        <div class="w-full flex flex-wrap">
          <form-field class="w-full lg:w-1/2 px-2" name="begin_at" label="Fecha de Inicio">
            <date-input name="begin_at" v-validate="{date_format: 'YYYY-MM-DD'}" class="form-field" v-model="row.data.begin_at" />
          </form-field>
          <form-field class="w-full lg:w-1/2 px-2" name="finish_at" label="Fecha de Finalización">
            <date-input name="finish_at" v-validate="{date_format: 'YYYY-MM-DD'}" class="form-field" v-model="row.data.finish_at" />
          </form-field>
        </div>
        <form-field class="w-1/2 px-2" name="is_active" label="Activa">
          <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
        </form-field>
        <form-field class="w-1/2 px-2" name="allow_apply" label="Permitir envío de información">
          <radio-group v-model="row.data.allow_apply" name="allow_apply" v-validate="{required: true}" :options="$yesNo" />
        </form-field>
        <form-field class="w-1/2 px-2" name="category_id" label="Categoría">
          <choice-input id="category_id" v-model="row.data.category_id" v-validate="{required: true}" :options="$categories" name="category_id" placeholder="Categoría" value-key="id" label-key="name" />
        </form-field>
        <form-field class="w-1/2 px-2" name="subcategory_id" label="Subcategoría">
          <choice-input id="subcategory_id" v-model="row.data.subcategory_id" :options="category.subcategories" name="subcategory_id" placeholder="Categoría" value-key="id" label-key="name" :no-options="row.data.category_id ? (!category.subcategories.length ? 'No hay subcategorías' : 'Sin resultados') : 'Selecciona una categoría'" />
        </form-field>
        <form-field class="w-full px-2" name="bidder_id" label="Oferente">
          <v-select @input="onBidderSelected" class="form-field" label="name" :filterable="false" v-model="bidder" :options="bidders" @search="onSearch">
            <template slot="no-options">
              Busca un oferente por nombre
            </template>
          </v-select>
        </form-field>
      </div>
      <div class="lg:w-1/3 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper :ratio="1.75" v-model="row.data.image_crop" :default="row.data.image || null"/>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Describe la oportunidad</h2>
    <form-field class="w-full" name="summary" label="Resumen">
      <textarea class="form-field text-sm resize-none h-32 rounded-lg leading-loose" maxlength="140" v-model="row.data.summary" v-validate="{required: true, max: 140}" name="summary" ></textarea>
      <remaining-count class="text-sm text-right mt-2" :length="(row.data.summary || '').length" :max="140" />
    </form-field>
    <form-field class="w-full" name="description" label="Descripción">
      <wysiwyg v-validate="{required: true}" class="bg-white" v-model="row.data.description" name="description" />
    </form-field>
    <form-field class="w-full" name="requirements" label="Requisitos">
      <wysiwyg class="bg-white" v-model="row.data.requirements" name="requirements" />
    </form-field>
    <form-field class="w-full" name="characteristics" label="Características">
      <wysiwyg class="bg-white" v-model="row.data.characteristics" name="characteristics" />
    </form-field>
    <form-field class="w-full" name="link" label="Ingresa un enlace si existe uno">
      <input type="url" name="link" v-validate="{url: true}" class="form-field text-sm" v-model="row.data.link" placeholder="http://">
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Ubicación</h2>
    <div class="flex flex-wrap -mx-2">
      <form-field class="px-2 w-full lg:w-1/3" name="country_id" label="País">
        <country-select name="country_id" v-model="row.data.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="state_id" label="Departamento">
        <state-select name="state_id" v-model="row.data.state_id" :country-id="row.data.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="city_id" label="Municipio">
        <city-select name="city_id" v-model="row.data.city_id" :state-id="row.data.state_id" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Intereses</h2>
    <form-field class="w-full" :error="null" label="Intereses">
      <label class="whitespace-no-wrap inline-block mb-2 radio text-sm mr-3" v-for="category in interests">
        <input type="checkbox" :id="`interest-${category.id}`" :value="category.id" v-model="row.data.tag_ids">
        {{category.name}}
      </label>
    </form-field>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Habilidades requeridas</h2>
    <form-field class="w-full" :error="null" label="Agregar Habilidad">
      <v-select label="name" @input="addSkill" :options="skills" class="form-field">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <div class="flex flex-wrap -mx-1">
      <div class="px-1" v-for="skill in row.data.skills">
        <div class="text-sm py-1 px-2 rounded-xl border-2 border-cyan text-cyan flex items-center">
          <confirm-button idle-class="text-cyan" class="mr-2" padding="p-0" icon-size="w-3 h-3" @confirmed="removeSkill(skill)" />
          {{skill.name}}
        </div>
      </div>
    </div>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import find from 'lodash/find';
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import FormPage from '@/components/admin/FormPage.vue';

var row = {
  name: '',
  summary: '',
  description: '',
  requirements: '',
  characteristics: '',
  link: '',
  skills: [],
  tag_ids: [],
  skill_ids: []
};

export default {
  extends: FormPage,
  data() {
    return {
      row: {data: Object.assign({}, row)},
      bidder: null,
      bidders: [],
      skills: [],
      interests: [],
    };
  },
  async created() {
    var response = await this.$http.get('interests');
    this.interests = response.data.data;

    response = await this.$http.get('skills');
    this.skills = response.data.data;

    if (!this.row.data.country_id) {
      this.row.data = Object.assign(this.row.data, {
        country_id: this.$user.country_id
      });
    }

    if (this.row.data.bidder) {
      this.bidder = this.row.data.bidder;
    }
  },
  computed: {
    category() {
      return find(this.$categories, {
        id: this.row.data.category_id
      }) || {subcategories: []};
    }
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.opportunities.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: Object.assign({}, row)
      };
    },
    addSkill(skill) {
      if (skill && !find(this.row.data.skills, {id: skill.id})) {
        this.row.data.skills.push(skill);
        this.row.data.skill_ids.push(skill.id);
      }
    },
    removeSkill(skill) {
      var idIndex = this.row.data.skill_ids.indexOf(skill.id);
      var index = findIndex(this.row.data.skills, {id: skill.id});
      if (index >= 0) {
        this.row.data.skills.splice(index, 1);
      }
      if (idIndex >= 0) {
        this.row.data.skill_ids.splice(idIndex, 1);
      }
    },
    onBidderSelected() {
      this.row.data.bidder_id = this.bidder ? this.bidder.id : null;
    },
    onSearch(term, loading) {
      loading(true);
      this.search(loading, term, this);
    },
    search: debounce((loading, term, vm) => {
      vm.$http.get('admin/bidders', {params: {term}})
        .then((res) => {
          if (vm.bidder && !res.data.data.length) {
            res.data.data.unshift(vm.bidder);
          }

          vm.bidders = res.data.data;
          loading(false);
        });
    }, 350)
  }
}
</script>
