<template lang="html">
  <section class="pt-24">
    <div class="container py-8">
      <breadcrumbs-list />
    </div>
    <div class="container text-grey-darker text-justify">
      <div class="md:w-3/4 mx-auto py-8">
        <bidder-detail :bidder="bidder.data" />
      </div>
      <div class="flex justify-between items-center xs:flex-col pt-8">
        <h1 class="font-dosis text-purple font-bold flex-none">Oportunidades</h1>
      </div>
      <div class="h-px bg-cyan my-8"></div>
      <div class="flex flex-wrap py-8 -mx-4" v-if="hasResults">
        <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in opportunities.data" :key="`opportunity-${opportunity.id}`">
          <opportunity-preview :opportunity="opportunity"></opportunity-preview>
        </div>
      </div>
      <div v-else>
        <alert-box message="Este oferente no tiene ha publicado oportunidades" />
      </div>
    </div>
  </section>
</template>

<script>
import {resolve, http} from '@/plugins/http';

function getData(bidder_id, next, vm = null) {
  resolve({
    bidder() {
      return http.get('/bidders/' + bidder_id);
    },
    opportunities(bidder) {
      return http.get('/opportunities', {params: {per_page: 4}})//, bidder_id: bidder.data.data.id}});
    }
  }, next, vm);
}
export default {
  data() {
    return {
      bidder: {data:{bidder:{}}},
      opportunities: {}
    };
  },
  computed: {
    hasResults() {
      var data = this.opportunities.data || [];
      return data.length > 0;
    }
  },
  beforeRouteEnter (to, from, next) {
    getData(to.params.slug, next);
  },
  beforeRouteUpdate (to, from, next) {
    this.bidder = {};
    getData(to.params.slug, next, this);
  }
}
</script>
