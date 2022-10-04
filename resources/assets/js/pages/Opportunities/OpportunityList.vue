<template lang="html">
  <section class="pt-24">
    <div class="container py-8">
      <breadcrumbs-list />
    </div>
    <div class="inner-banner relative mb-8">
      <template v-if="banner">
        <img :src="banner" alt="Oportunidades" class="block w-full h-auto" width="1440" height="400">
      </template>
      <template v-else>
        <img src="~@img/opportunities-header.jpg" alt="Oportunidades" class="block w-full h-auto" width="1440" height="400">
      </template>
    </div>
    <div class="container py-8">
      <div class="lg:flex justify-between items-center flex-row">
        <h1 class="font-dosis text-purple font-bold flex-none">{{title}}</h1>
        <div class="flex-none relative -mx-2">
          <div class="lg:absolute text-grey-dark font-dosis font-bold pin-l px-2 pb-2 pt-4" style="bottom:100%">Filtra las oportunidades por:</div>
          <div class="flex w-full flex-wrap pt-2 lg:pt-0">
            <div class="lg:w-48 flex-none w-1/3 px-2" v-if="category && category.subcategories.length">
              <choice-input @input="this.resetOpportunities" v-model="query.subcategory_id" :options="category.subcategories" name="subcategory_id" :empty-text="query.subcategory_id ? 'Todas' : 'Subcategoría'" value-key="id" label-key="name" />
            </div>
            <div class="lg:w-48 flex-none w-1/2 px-2" :class="{'md:w-1/3':(category ? category.subcategories.length : true)}">
              <state-select @input="this.resetOpportunities" v-model="query.state_id" :country-id="$country.id" class="form-field" />
            </div>
            <div class="lg:w-48 flex-none w-1/2 px-2" :class="{'md:w-1/3':(category ? category.subcategories.length : true)}">
              <city-select @input="this.resetOpportunities" v-model="query.city_id" :state-id="query.state_id" class="form-field" />
            </div>
            <div class="md:w-1/3 lg:w-48 flex-none w-full px-2 pt-4 md:pt-0" v-if="!category">
              <choice-input @input="this.resetOpportunities" v-model="query.category_id" :options="$categories" name="category_id" :empty-text="query.category_id ? 'Todas' : 'Categoría'" value-key="id" label-key="name" />
            </div>
          </div>
        </div>
      </div>
      <p class="text-justify my-8 text-lg text-grey-dark" v-if="description">{{description}}</p>
      <div class="h-px bg-cyan my-8"></div>
      <template v-if="searching">
        <search-in />
        <div class="h-px bg-cyan my-8"></div>
      </template>
      <div class="flex flex-wrap pt-8 -mx-4" v-if="hasResults">
        <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in opportunities.data" :key="`opportunity-${opportunity.id}`">
          <opportunity-preview :opportunity="opportunity"></opportunity-preview>
        </div>
      </div>
      <div v-else>
        <alert-box message="No encontramos oportunidades con esos criterios de búsqueda"/>
      </div>
      <div class="py-8 flex justify-center" v-if="lastPage > 1">
        <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
      </div>
    </div>
  </section>
</template>

<script>
import {resolve, http} from '@/plugins/http';
import Vue from 'vue/dist/vue.runtime';
import find from 'lodash/find';
import pickBy from 'lodash/pickBy';
import assign from 'lodash/assign';

function getOpportunities(to, next, vm = null) {
  let params = vm ? vm.query : {};

  assign(params, {
    term: to.query.term || ''
  });

  params = pickBy(params, (v) => !!v);

  resolve({
    category_id() {
      if (to.name == 'category') {
        return new Promise((resolve, reject) => {
          var category;


          if (Vue.router.app.categories.length) {
            category = find(Vue.router.app.categories, {
              slug: to.params.category
            }) || {};

            resolve(category.id || false);
          } else {
            Vue.router.app.$on('categories-loaded', function (categories) {
              console.log('loaded')
              category = find(categories, {
                slug: to.params.category
              }) || {};

              resolve(category.id || false);
            });
          }
        });
      }

      return Promise.resolve(false);
    },
    opportunities(category_id) {
      if (category_id) {
        params.category_id = category_id;
      }

      return http.get('/opportunities', {params});
    }
  }, next, vm);
}

export default {
  data() {
    return {
      query: {
        page: 1,
        state_id: null,
        city_id: null,
        category_id: null
      },
      opportunities: {}
    }
  },
  computed: {
    state() {
      var id = this.query.state_id || null;
      return find(this.$country.states, {id}) || {cities: []};
    },
    category() {
      if (this.$route.name == 'category' && this.$route.params.category) {
        return find(this.$categories, {slug: this.$route.params.category}) || null;
      }

      return null;
    },
    hasResults() {
      var data = this.opportunities.data || [];
      return data.length > 0;
    },
    lastPage() {
      var meta = this.opportunities.meta || {last_page: 1}
      return meta.last_page;
    },
    title() {
      if (this.category) {
        return this.category.title || this.category.name;
      }

      var term = this.$route.query.term || false;
      return term ? `Resultados para: ${term}` : 'Oportunidades';
    },
    description() {
      return this.category ? this.category.description : null;
    },
    banner() {
      return this.category && this.category.banner ? this.category.banner.url : null;
    },
    searching() {
      return !!this.$route.query.term;
    }
  },
  beforeRouteEnter (to, from, next) {
    getOpportunities(to, next);
  },
  beforeRouteUpdate (to, from, next) {
    this.opportunities = {};
    getOpportunities(to, next, this);
  },
  methods: {
    onPageChange (pageNum) {
      this.query.page = pageNum;
      this.reloadOpportunities();
    },
    resetOpportunities() {
      this.query.page = 1;
      getOpportunities(this.$route, ()=>{}, this);
    },
    reloadOpportunities() {
      getOpportunities(this.$route, ()=>{}, this);
    }
  }
}
</script>
