<template lang="html">
  <div class="py-8">
    <index-view @filter="filtering=true" ref="index" :url="url" title="Oportunidades">
      <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4" slot="item" slot-scope="item">
        <div class="xs:w-full sm:flex-1 xs:pb-2">
          <p class="text-red font-bold font-dosis mb-1">
            <a class="text-red no-underline" href @click.prevent="showOpportunity(item.row)">{{item.row.name}}</a>
          </p>
          <p class="text-grey-dark text-xs mb-2" v-if="item.row.bidder">
            <strong>Oferente:</strong> <a class="text-red no-underline" href @click.prevent="showBidder(item.row.bidder)">{{item.row.bidder.name}}</a>
          </p>
          <p class="text-grey-dark text-xs mb-2">
            <location-name :row="item.row"/>
          </p>
          <div class="flex items-center">
            <toggle-pill active-text="Activa" idle-text="No activa" :active="!!item.row.is_active" />
            <toggle-pill :active-text="`Vigente hasta ${$dayjs(item.row.finish_at).format('YYYY/MM/DD')}`" :idle-text="item.row.is_expired ? `Expirada el ${$dayjs(item.row.finish_at).format('YYYY/MM/DD')}` : `Próximamente desde ${$dayjs(item.row.begin_at).format('YYYY/MM/DD')}`" :active="item.row.is_valid" :idle-class="item.row.is_expired ? 'bg-red' : 'bg-cyan'" />
            <category-pill :id="item.row.category_id" class="text-xs mr-2" />
          </div>
        </div>
        <div class="flex-none w-24 xs:w-1/2 sm:text-center">
          <span class="font-dosis text-xs">{{ item.row.created_at | date }}</span>
        </div>
      </div>

      <template slot="item-actions" slot-scope="item">
        <router-link :to="{name: 'admin.opportunities.edit', params: { id: item.row.id }}" class="outline-none focus:outline-none p-2 appearance-none flex items-center" v-tooltip.top-center="'Editar'"><svg-icon src="~@svg/icons/regular/edit.svg" class="block fill-current w-4 h-4" /></router-link>
        <toggle-button @toggled="item.row.is_active=$event" :active="!!item.row.is_active" :url="$refs['index'].parseUrl({id: item.row.id, toggle: 'active'})" />
      </template>

      <template slot="actions">
        <router-link :to="{name: 'admin.opportunities.create'}" class="btn bg-teal uppercase text-white">Agregar</router-link>
      </template>

      <template slot="filters" slot-scope="index">
        <div class="flex-wrap items-end mb-6 -mx-2 hidden md:flex">
          <div class="px-2 w-full sm:w-1/4 flex-none">
            <form-field label-class="text-xs" name="term" label="Buscar">
              <input placeholder="Nombre de la oportunidad" type="text" v-model="index.query.term" class="form-field text-xs py-1">
            </form-field>
          </div>
          <div class="px-2 w-full sm:w-1/5 flex-none">
            <form-field label-class="text-xs" name="term" label="Categoría">
              <choice-input name="category_id" class="text-xs" v-model="index.query.category_id" :options="$categories" label-key="name" value-key="id" empty-text="Categoría" />
            </form-field>
          </div>
          <div class="px-2 w-full sm:w-1/5 flex-none">
            <form-field label-class="text-xs" name="bidder_id" label="Oferente">
              <v-select @input="onBidderSelected($event, index)" class="form-field text-xs" label="name" :filterable="false" v-model="filterBidder" :options="bidders" @search="onSearch" placeholder="Oferente">
                <template slot="no-options">
                  Busca un oferente por nombre
                </template>
              </v-select>
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
          <div class="flex flex-wrap -mx-2">
            <div class="px-2 w-full md:w-1/2">
              <form-field label-class="text-xs" name="term" label="Activas">
                <choice-input :options="$yesNo" name="active" empty-text="Todas" class="text-xs" v-model="index.query.active" />
              </form-field>
            </div>
            <div class="px-2 w-full md:w-1/2">
              <form-field label-class="text-xs" name="term" label="Vigencia">
                <choice-input :options="$yesNo" name="available" empty-text="Todas" class="text-xs" v-model="index.query.available" />
              </form-field>
            </div>
          </div>
          <form-field label-class="text-xs" name="bidder_id" label="Oferente">
            <v-select @input="onBidderSelected($event, index)" class="form-field text-xs" label="name" :filterable="false" v-model="filterBidder" :options="bidders" @search="onSearch" placeholder="Oferente">
              <template slot="no-options">
                Busca un oferente por nombre
              </template>
            </v-select>
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
    <modal-dialog :shown="!!opportunity" @modal-close="opportunity=null">
      <opportunity-detail :opportunity="opportunity" />
    </modal-dialog>
    <modal-dialog :shown="!!bidder" @modal-close="bidder=null">
      <bidder-detail :bidder="bidder" />
    </modal-dialog>
  </div>
</template>

<script>
import debounce from 'lodash/debounce';
export default {
  data() {
    return {
      filtering: false,
      opportunity: null,
      bidder: null,
      bidders: [],
      filterBidder: null,
      url: '/admin/opportunities/:id?/:toggle?'
    }
  },
  methods: {
    showOpportunity(row) {
      this.opportunity = row;
    },
    showBidder(row) {
      this.bidder = row;
    },
    filter() {
      this.filtering = false;
    },
    onBidderSelected(bidder, vm) {
      vm.query.bidder_id = bidder ? bidder.id : null;
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
