<template lang="html">
  <div>
    <section class="pt-24">
      <div class="container py-8">
        <breadcrumbs-list />
      </div>
      <div class="inner-banner relative mb-8">
        <img src="~@img/bidders-header.jpg" alt="Oportunidades" class="block w-full h-auto" width="1440" height="400">
      </div>
      <div class="container py-8">
        <div class="flex justify-between items-center xs:flex-col">
          <h1 class="font-dosis text-purple font-bold flex-none">{{title}}</h1>
        </div>
        <div class="h-px bg-cyan my-8"></div>
        <template v-if="searching">
          <search-in />
          <div class="h-px bg-cyan my-8"></div>
        </template>
        <div class="flex flex-wrap py-8 -mx-4" v-if="hasResults">
          <div class="px-4 w-full md:w-1/2" v-for="bidder in bidders.data" :key="`bidder-${bidder.id}`">
            <bidder-preview :bidder="bidder" />
          </div>
        </div>
        <div v-else>
          <alert-box message="No encontramos oferentes con esos criterios de búsqueda"/>
        </div>
        <div class="py-8 flex justify-center" v-if="lastPage > 1">
          <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
        </div>
      </div>
    </section>
    <section class="bg-teal py-12">
      <div class="container flex flex-col sm:flex-row items-center">
        <p class="font-dosis text-2xl flex-1 leading-none text-white">¿Quiéres ser un oferente y darle un Chance a los jóvenes?</p>
        <p class="flex-1 sm:flex-none leading-none text-white"><router-link :to="{name: 'register.bidder'}" class="btn bg-white text-teal uppercase">Regístrate</router-link></p>
      </div>
    </section>
  </div>
</template>

<script>
import {resolve, http} from '@/plugins/http';
import pickBy from 'lodash/pickBy';
import assign from 'lodash/assign';

function getBidders(to, next, vm = null) {
  let params = vm ? vm.query : {};

  assign(params, {
    term: to.query.term || ''
  });

  params = pickBy(params, (v) => !!v);

  resolve({
    bidders() {
      return http.get('/bidders', {params});
    }
  }, next, vm);
}

export default {
  data() {
    return {
      query: {
        page: 1,
      },
      bidders: {}
    }
  },
  computed: {
    hasResults() {
      var data = this.bidders.data || [];
      return data.length > 0;
    },
    lastPage() {
      var meta = this.bidders.meta || {last_page: 1}
      return meta.last_page;
    },
    title() {
      var term = this.$route.query.term || false;
      return term ? `Resultados para: ${term}` : 'Oferentes';
    },
    searching() {
      return !!this.$route.query.term;
    }
  },
  beforeRouteEnter (to, from, next) {
    getBidders(to, next);
  },
  beforeRouteUpdate (to, from, next) {
    this.bidders = {};
    getBidders(to, next, this);
  },
  methods: {
    onPageChange (pageNum) {
      this.query.page = pageNum;
      getBidders(this.$route, ()=>{}, this);
    },
    bidderImage(bidder) {
      if (bidder.image) {
        return bidder.image.url;
      }

      return '/images/bidder-dummy.jpg';
    }
  }
}
</script>
