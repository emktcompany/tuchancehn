<template lang="html">
  <div>
    <div class="flex justify-between items-center flex-col sm:flex-row -mx-4 mb-3">
      <h1 class="font-dosis text-cyan font-bold flex-none px-4 mb-4 sm:mb-0">{{title}}</h1>
      <div class="index-actions w-full justify-center sm:w-auto flex flex-wrap flex-none -mx-2 px-4">
        <slot name="actions" />
      </div>
    </div>
    <form @submit.prevent="search" v-if="filters">
      <div class="text-grey-darker flex px-4 py-2 border-grey bg-grey-lighter justify-between md:hidden hover:bg-grey cursor-pointer rounded mb-2" @click.prevent="$emit('filter')">
        <div class="flex-none">
          Filtrar resultados
        </div>
        <div class="flex-none w-6">
          <a href @click.prevent class="no-underline block text-grey-darker"><svg-icon class="stroke-current w-3 h-3" src="~@svg/icons/solid/filter.svg"></svg-icon></a>
        </div>
      </div>
      <slot name="filters" :search="search" :query="query" />
    </form>
    <template v-if="loaded">
      <div class="text-right text-sm text-grey-dark pb-4">{{showingResults}}</div>
      <ul class="list-reset rounded list-group">
        <li class="list-item flex hover:shadow" v-for="row in resources.data">
          <div class="flex-1 flex items-center">
            <slot name="item" :row="row" />
          </div>
          <div class="py-6 px-4 flex-none flex">
            <slot name="item-actions" :row="row" />
            <confirm-button @confirmed="deleteRow(row)" v-if="allowDelete" />
          </div>
        </li>
      </ul>
      <div class="py-8 flex justify-center" v-if="lastPage > 1">
        <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
      </div>
    </template>
    <alert-box v-if="loaded && !resources.data.length" message="No encontramos registros con esos criterios de búsqueda" />
  </div>
</template>

<script>
import findIndex from 'lodash/findIndex';
import {compile} from 'path-to-regexp';

export default {
  props: {
    title: {
      type: String,
      required: true
    },
    url: {
      type: String,
      required: true
    },
    allowDelete: {
      type: Boolean,
      default: true
    },
    filters: {
      type: Boolean,
      default: true
    },
    params: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      resources: {data: [], meta: {}},
      loading: false,
      loaded: false,
      query: {}
    };
  },
  computed: {
    hasResults() {
      var data = this.resources.data || [];
      return data.length > 0;
    },
    lastPage() {
      var meta = this.resources.meta || {last_page: 1}
      return meta.last_page || 1;
    },
    showingResults() {
      var meta     = this.resources.meta || {};
      var per_page = meta.per_page || 10;
      var page     = meta.page || 1;
      var from     = (page - 1) * per_page;
      var total    = meta.total || 0;
      var to       = Math.min(from + per_page, total);
      return `Mostrando resultados ${from + 1} al ${to} de ${total}`;
    }
  },
  created() {
    this.query = Object.assign({}, this.params);
    this.refresh();
  },
  methods: {
    onPageChange (pageNum) {
      this.query.page = pageNum;
      this.refresh();
    },
    search(query = {}) {
      this.query.page = 1;
      this.refresh();
    },
    async refresh() {
      this.loading = true;

      try {
        var response = await this.$http.get(this.parseUrl(), {
          params: this.query
        });

        this.onLoaded(response);
      } catch (e) {
        this.onError(e);
      } finally {
        this.loading = false;
      }
    },
    onLoaded(response) {
      this.loaded  = true;
      this.$emit('loaded', response);
      this.resources = response.data;
    },
    onError(error) {
      this.$emit('error', error);
      this.$notify({
        text: error,
        title: 'Error',
        type: 'error'
      });
    },
    async deleteRow(row) {
      var filter  = {id: row.id};
      const index = findIndex(this.resources.data, filter);

      if (index >= 0) {
        var response = await this.$http.delete(this.parseUrl(filter));

        this.$notify({
          text: 'Borrado con éxito',
          title: 'Éxito',
          type: 'success'
        })

        this.refresh();
      }
    },
    parseUrl(filter = {}) {
      var url = compile(this.url);
      return url(filter);
    }
  }
}
</script>

<style lang="scss" scoped>
  .index-actions {
    > * {
      @apply mx-1;
    }
  }

  .list-group {
    @apply border border-grey-light ;
  }

  .list-item {
    @apply border-t border-grey-light text-grey-darker ;

    &:first-of-type {
      @apply rounded-t border-t-0 ;
    }

    &:last-of-type {
      @apply rounded-b ;
    }
  }
</style>
