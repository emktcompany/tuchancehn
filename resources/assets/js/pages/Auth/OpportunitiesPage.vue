<template lang="html">
  <section class="relative pt-32 bg-white min-h-screen">
    <div class="container overflow-hidden">
      <breadcrumbs-list />
      <div class="-mx-8 flex flex-wrap justify-between">
        <div class="px-8 flex-1">
          <h1 class="mt-12 mb-6 text-red font-dosis font-bold">Mis oportunidades</h1>
        </div>
      </div>
      <div class="bg-grey-lighter p-4 md:p-12 mb-12">
        <ul v-if="hasResults" class="list-reset rounded list-group bg-white">
          <li class="list-item flex hover:shadow" v-for="row in enrollments.data">
            <div class="flex-1 flex items-center">
              <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4">
                <div class="xs:w-full sm:flex-1 xs:pb-2">
                  <p class="text-cyan font-bold font-dosis mb-2 text-lg">
                    <a class="text-cyan no-underline" href @click.prevent="showOpportunity(row)">{{row.name}}</a>
                  </p>
                  <div class="mb-2 flex -mx-1">
                    <div class="px-1 flex"><category-pill :id="row.category_id" v-if="row.category_id" /></div>
                    <div class="px-1 flex"><a href v-ripple @click.prevent.stop="goToOpportunities" class="rounded-xl flex items-center no-underline text-white px-2 py-1 text-xs " :class="{'bg-grey': !row.enrollment.is_accepted, 'bg-teal': row.enrollment.is_accepted}">
                      {{!row.enrollment.is_accepted?'Pendiente':'Aceptada'}}
                    </a></div>
                  </div>
                  <p class="mb-2">{{row.summary}}</p>
                </div>
                <div class="flex-none w-24 xs:w-1/2 sm:text-center">
                  <span class="font-dosis text-xs">{{ row.enrollment.created_at | date }}</span>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="py-8 flex justify-center" v-if="lastPage > 1">
          <pagination-links :value="query.page" :click-handler="onPageChange" :page-count="lastPage" container-class="pagination" active-class="active" prev-text="&laquo;" next-text="&raquo;" />
        </div>
      </div>
    </div>
    <modal-dialog :shown="!!opportunity" @modal-close="opportunity=null">
      <opportunity-detail :opportunity="opportunity" />
    </modal-dialog>
  </section>
</template>

<script>
import {resolve, http} from '@/plugins/http';

function getEnrollments(to, next, vm = null) {
  resolve({
    enrollments() {
      return http.get('/opportunities/enrolled');
    }
  }, next, vm);
}
export default {
  data() {
    return {
      query: {page: 1},
      opportunity: null,
      enrollments: {data: []}
    };
  },
  beforeRouteEnter (to, from, next) {
    getEnrollments(to, next);
  },
  beforeRouteUpdate (to, from, next) {
    this.enrollments = {};
    getEnrollments(to, next, this);
  },
  computed: {
    hasResults() {
      var data = this.enrollments.data || [];
      return data.length > 0;
    },
    lastPage() {
      var meta = this.enrollments.meta || {last_page: 1}
      return meta.last_page;
    }
  },
  methods: {
    showOpportunity(row) {
      this.opportunity = row;
    },
    onPageChange (pageNum) {
      this.query.page = pageNum;
      getEnrollments(this.$route, ()=>{}, this);
    }
  }
}
</script>

<style lang="scss" scoped>
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
