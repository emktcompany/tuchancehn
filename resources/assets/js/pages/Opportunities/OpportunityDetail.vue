<template lang="html">
  <section class="pt-24">
    <div class="container py-8">
      <breadcrumbs-list />
    </div>
    <div class="inner-banner relative mb-8">
      <img src="~@img/opportunity-header.jpg" alt="Oportunidades" class="block w-full h-auto" width="1440" height="400">
    </div>
    <div class="container text-grey-darker text-justify">
      <opportunity-detail @enrolled="enrolled" :opportunity="opportunity.data" />
    </div>
  </section>
</template>

<script>
import {resolve, http} from '@/plugins/http';

function getOpportunity(id, next, vm = null) {
  return resolve({
    opportunity() {
      return http.get('/opportunities/' + id);
    }
  }, next, vm);
}
export default {
  data() {
    return {
      opportunity: {data:{bidder:{}}}
    };
  },
  beforeRouteEnter (to, from, next) {
    getOpportunity(to.params.slug, next);
  },
  beforeRouteUpdate (to, from, next) {
    this.opportunity = {data:{bidder:{}}};
    getOpportunity(to.params.slug, next, this);
  },
  methods: {
    enrolled(enrollment) {
      this.opportunity = {data: enrollment.opportunity};
    }
  }
}
</script>
