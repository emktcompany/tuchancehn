<template lang="html">
  <div class="py-8">
    <index-view ref="index" :url="url" title="Conexiones">
      <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4" slot="item" slot-scope="item">
        <div class="xs:w-full sm:flex-1 xs:pb-2">
          <div class="flex -mx-1">
            <div class="px-1 flex-none">
              <p class="text-red font-bold font-dosis mb-2">
                <a class="text-red no-underline" href @click.prevent="showCandidate(item.row.candidate)">{{item.row.candidate.user.name}}</a>
              </p>
            </div>
            <div class="px-1 flex-none">
              <likeness-ratio :candidate-skills="item.row.candidate.skills" :opportunity-skills="item.row.opportunity.skills" :likeness="item.row.likeness" />
            </div>
            <div class="px-1 flex-none">
              <pro-joven-status v-if="item.row.candidate.projoven_estatus" :centro="item.row.candidate.projoven_centro" :estatus="item.row.candidate.projoven_estatus" :curso="item.row.candidate.projoven_curso" />
            </div>
          </div>
          <p class="text-grey-dark text-xs">
            <toggle-pill :active="!!item.row.is_accepted" active-text="Aceptada" idle-text="Sin Aceptar" />
            <toggle-pill :active="!!item.row.is_fullfilled" active-text="Completada" idle-text="Sin Completar" />
            &bull; <strong>Oportunidad: </strong> <a class="text-red no-underline" href @click.prevent="showOpportunity(item.row.opportunity)">{{item.row.opportunity.name}}</a>
          </p>
        </div>
        <div class="flex-none w-24 xs:w-1/2 sm:text-center">
          <span class="font-dosis text-xs">{{ item.row.created_at | date }}</span>
        </div>
      </div>

      <template slot="item-actions" slot-scope="item">
        <toggle-button @toggled="item.row.is_accepted=$event" :active="!!item.row.is_accepted" :url="$refs['index'].parseUrl({id: item.row.id, toggle: 'accepted'})" active-text="Rechazar" idle-text="Aceptar" />
        <toggle-button @toggled="item.row.is_fullfilled=$event" :active="!!item.row.is_fullfilled" :url="$refs['index'].parseUrl({id: item.row.id, toggle: 'fullfilled'})" active-text="Marcar no completada" idle-text="Completar" />
      </template>

      <template slot="filters" slot-scope="index">
        <div class="flex items-end mb-6 -mx-3">
          <div class="px-3 w-full sm:w-1/3 flex-none">
            <form-field label-class="text-xs" name="term" label="Buscar">
              <input placeholder="Nombre de usuario u oportunidad" type="text" v-model="index.query.term" class="form-field text-xs">
            </form-field>
          </div>
          <div class="flex-none px-3 py-2">
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
          <form-field label-class="text-xs" name="term" label="Categoría">
            <choice-input name="category_id" class="text-xs" v-model="index.query.category_id" :options="$categories" label-key="name" value-key="id" empty-text="Categoría" />
          </form-field>
          <form-field label-class="text-xs" name="term" label="Género">
            <choice-input :options="$genders" name="gender" empty-text="Todos" class="text-xs" v-model="index.query.gender" />
          </form-field>
          <form-field label-class="text-xs" name="term" label="Completado">
            <choice-input :options="$yesNo" name="is_fullfilled" empty-text="Todos" class="text-xs" v-model="index.query.is_fullfilled" />
          </form-field>
          <form-field label-class="text-xs" name="term" label="Aceptado">
            <choice-input :options="$yesNo" name="is_accepted" empty-text="Todos" class="text-xs" v-model="index.query.is_accepted" />
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
    <modal-dialog :shown="!!candidate" @modal-close="candidate=null">
      <candidate-detail :candidate="candidate" />
    </modal-dialog>
  </div>
</template>

<script>

import LikenessRatio from '@/components/admin/LikenessRatio.vue';
import ProJovenStatus from '@/components/admin/ProJovenStatus.vue';
export default {
  components: {
    LikenessRatio,
    ProJovenStatus
  },
  data() {
    return {
      filtering: false,
      candidate: null,
      opportunity: null,
      url: '/admin/enrollments/:id?/:toggle?'
    }
  },
  methods: {
    showOpportunity(row) {
      this.opportunity = row;
    },
    showCandidate(row) {
      this.candidate = row;
    },
    filter() {
      this.filtering = false;
    }
  }
}
</script>
