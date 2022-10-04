<template lang="html">
  <div>
    <div class="flex justify-between items-center flex-col lg:flex-row -mx-4">
      <h1 class="font-dosis text-purple font-bold flex-none px-4 mb-6 lg:mb-0">{{title}}</h1>
      <div class="index-actions justify-center w-full lg:w-auto flex flex-wrap flex-none -mx-2 px-4">
        <slot name="actions" />
      </div>
    </div>
    <slot name="filters" />
    <template v-if="loaded">
      <div class="h-px bg-cyan my-8"></div>
      <v-draggable @end="saveSort" :options="{draggable:'.list-item'}" v-model="resources.data" class="rounded list-group">
        <div class="list-item bg-white flex hover:shadow cursor-move" v-for="row in resources.data">
          <div class="flex items-center pl-4">
            <svg-icon src="~@svg/icons/solid/grip-lines.svg" class="fill-current w-4 h-4" />
          </div>
          <div class="flex-1 flex items-center">
            <slot name="item" :row="row" />
          </div>
        </div>
      </v-draggable>
    </template>
    <alert-box v-if="loaded && !resources.data.length" message="No encontramos registros con esos criterios de búsqueda" />
  </div>
</template>

<script>
import map from 'lodash/map';
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
  created() {
    this.refresh()
  },
  methods: {
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
    async saveSort() {
      var response = await this.$http.put(this.parseUrl(), {
        sort: map(this.resources.data, 'id')
      });
      this.$notify({
        text: 'Orden actualizado con éxito',
        title: 'Éxito',
        type: 'success'
      });
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
