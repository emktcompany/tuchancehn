<template lang="html">
  <div class="py-8">
    <index-view ref="index" :url="url" title="Usuarios">
      <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4" slot="item" slot-scope="item">
        <div class="xs:w-full sm:flex-1 xs:pb-2">
          <p class="text-red font-bold font-dosis mb-2">
            <a class="text-red no-underline" href @click.prevent="showCandidate(item.row)">{{item.row.user.name}}</a>
          </p>
          <p class="text-grey-dark text-xs">
            <toggle-pill :active="!!item.row.user.is_active" />
            <location-name :row="item.row"/>
          </p>
        </div>
        <div class="flex-none w-24 xs:w-1/2 sm:text-center">
          <span class="font-dosis text-xs">{{ item.row.created_at | date }}</span>
        </div>
      </div>

      <template slot="item-actions" slot-scope="item">
        <router-link :to="{name: 'admin.candidates.edit', params: { id: item.row.id }}" class="outline-none focus:outline-none p-2 appearance-none flex items-center" v-tooltip.top-center="'Editar'"><svg-icon src="~@svg/icons/regular/edit.svg" class="block fill-current w-4 h-4" /></router-link>
        <toggle-button @toggled="item.row.user.is_active=$event" :active="!!item.row.user.is_active" :url="$refs['index'].parseUrl({id: item.row.id, toggle: 'active'})" />
      </template>

      <template slot="actions">
        <router-link :to="{name: 'admin.candidates.create'}" class="btn bg-teal uppercase text-white">Agregar</router-link>
      </template>

      <template slot="filters" slot-scope="index">
        <div class="flex items-end mb-6 -mx-2">
          <div class="px-2 w-full sm:w-1/4 flex-none">
            <form-field label-class="text-xs" name="term" label="Buscar">
              <input placeholder="Nombre o correo del candidato" type="text" v-model="index.query.term" class="form-field text-xs py-1">
            </form-field>
          </div>
          <div class="px-2 w-full sm:w-1/5 flex-none">
            <form-field label-class="text-xs" name="term" label="País">
              <country-select class="text-xs" v-model="index.query.country_id" />
            </form-field>
          </div>
          <div class="px-2 w-full sm:w-1/5 flex-none">
            <form-field label-class="text-xs" name="term" label="Departamento">
              <state-select class="text-xs" v-model="index.query.state_id" :country-id="index.query.country_id" />
            </form-field>
          </div>
          <div class="px-2 w-full sm:w-1/5 flex-none">
            <form-field label-class="text-xs" name="term" label="Ciudad">
              <city-select class="text-xs" v-model="index.query.city_id" :state-id="index.query.state_id" />
            </form-field>
          </div>
          <div class="flex-none px-2 py-2">
            <button type="submit" class="btn bg-purple uppercase text-white px-4 py-2">
              <svg-icon class="w-4 h-4 fill-none stroke-current" src="~@svg/search-icon.svg" />
            </button>
            <button v-tooltip="'Búsqueda avanzada'" @click.prevent="filtering=true" class="btn bg-purple uppercase text-white px-4 py-2">
              <svg-icon class="w-3 h-3 fill-current" src="~@svg/icons/solid/filter.svg" />
            </button>
          </div>
        </div>
        <modal-dialog width="max-w-sm" :shown="filtering" @modal-close="filtering=false">
          <p class="font-dosis text-purple text-2xl font-bold">Filtrar resultados</p>
          <hr class="my-3 border-t border-grey-dark">
          <form-field label-class="text-xs" name="term" label="Palabra Clave">
            <input placeholder="Nombre de la oportunidad" type="text" v-model="index.query.term" class="form-field text-xs py-1">
          </form-field>
          <form-field label-class="text-xs" name="term" label="País">
            <country-select class="text-xs" v-model="index.query.country_id" />
          </form-field>
          <div class="flex flex-wrap -mx-2">
            <div class="px-2 w-full md:w-1/2">
              <form-field label-class="text-xs" name="term" label="Departamento">
                <state-select class="text-xs" v-model="index.query.state_id" :country-id="index.query.country_id" />
              </form-field>
            </div>
            <div class="px-2 w-full md:w-1/2">
              <form-field label-class="text-xs" name="term" label="Municipio">
                <city-select class="text-xs" v-model="index.query.city" :state-id="index.query.state_id" />
              </form-field>
            </div>
          </div>
          <form-field label-class="text-xs" name="term" label="Categoría">
            <choice-input name="category_id" class="text-xs" v-model="index.query.category_id" :options="$categories" label-key="name" value-key="id" empty-text="Categoría" />
          </form-field>
          <form-field label-class="text-xs" name="term" label="Género">
            <choice-input :options="$genders" name="gender" empty-text="Todos" class="text-xs" v-model="index.query.gender" />
          </form-field>
          <form-field label-class="text-xs" name="term" label="Edad">
            <choice-input :options="ranges" name="age_range" empty-text="Todos" class="text-xs" v-model="index.query.age_range" />
          </form-field>
          <div class="text-right pt-4">
            <button @click.prevent="filtering=false" class="btn bg-grey-lighter uppercase text-grey text-sm">
              Cancelar
            </button>
            <button type="submit" @click="index.search(filtering=false)" class="btn bg-purple uppercase text-white text-sm">
              Filtrar
            </button>
          </div>
        </modal-dialog>
      </template>
    </index-view>
    <modal-dialog :shown="!!candidate" @modal-close="candidate=null">
      <candidate-detail :candidate="candidate"/>
    </modal-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filtering: false,
      candidate: null,
      ranges: [
        {value: '0 - 9', label: '1 - 9'},
        {value: '10 - 19', label: '10 - 19'},
        {value: '20 - 29', label: '20 - 29'},
        {value: '30 - 39', label: '30 - 39'},
        {value: '40 - 49', label: '40 - 49'},
        {value: '50 - 59', label: '50 - 59'},
        {value: '60 - 69', label: '60 - 69'},
        {value: '70 - 79', label: '70 - 79'},
        {value: '80 - 89', label: '80 - 89'},
      ],
      url: '/admin/candidates/:id?/:toggle?'
    }
  },
  methods: {
    showCandidate(row) {
      this.candidate = row;
    },
    filter() {
      this.filtering = false;
    }
  }
}
</script>
