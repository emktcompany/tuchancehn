<template lang="html">
  <section>

    <div class="flex flex-wrap justify-between items-center mb-6">
      <h2 class="flex-1 text-red font-dosis font-bold text-3xl">Dashboard</h2>
      <div class="pl-2 py-4 w-full sm:w-64 flex-none">
        <date-range-picker v-model="period" />
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="px-3 w-full md:w-1/4">
        <stat-box :count="candidate_count" label="Usuarios Registrados" bg-color="bg-cyan" class="border-b border-grey-lighter md:border-b-0" route="admin.stats.candidates">
          <svg-icon src="~@svg/icons/solid/user-graduate.svg" class="w-6 h-6 fill-current" />
        </stat-box>
      </div>
      <div class="px-3 w-full md:w-1/4">
        <stat-box :count="opportunity_count" label="Oportunidades Ingresadas" bg-color="bg-teal" class="border-b border-grey-lighter md:border-b-0" route="admin.stats.opportunities">
          <svg-icon src="~@svg/icons/solid/bullhorn.svg" class="w-6 h-6 fill-current" />
        </stat-box>
      </div>
      <div class="px-3 w-full md:w-1/4">
        <stat-box :count="bidder_count" label="Oferentes Registrados" bg-color="bg-orange" class="border-b border-grey-lighter md:border-b-0" route="admin.stats.bidders">
          <svg-icon src="~@svg/icons/solid/user-tie.svg" class="w-6 h-6 fill-current" />
        </stat-box>
      </div>
      <div class="px-3 w-full md:w-1/4">
        <stat-box :count="enrollment_count" label="Conexiones Generadas" bg-color="bg-purple" route="admin.stats.enrollments">
          <svg-icon src="~@svg/icons/solid/share.svg" class="w-6 h-6 fill-current" />
        </stat-box>
      </div>
    </div>


    <div class="bg-white shadow-lg p-1 md:p-4">
      <base-chart :chart-data="chartData" />
    </div>

    <div class="flex -mx-3 flex-wrap">
      <div class="w-full md:w-1/3 px-3 mt-6">
        <div class="bg-white shadow-md list-group">
          <h2 class="font-dosis font-bold text-lg sm:text-md lg:text-xl bg-cyan list-group-item p-4 text-white">Oportunidades populares</h2>
          <div class="list-group-item items-center justify-between flex p-4" v-for="row in topOpportunities">
            <p class="flex-1 uppercase text-xs">{{row.opportunity}}</p>
            <div class="flex-none text-xs bg-grey text-white rounded-full ml-2 w-6 h-6 flex justify-center items-center">{{row.count}}</div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-3 mt-6">
        <div class="bg-white shadow-md list-group">
          <h2 class="font-dosis font-bold text-lg sm:text-md lg:text-xl bg-red list-group-item p-4 text-white">Categorías populares</h2>
          <div class="list-group-item items-center justify-between flex p-4" v-for="row in topCategories">
            <p class="flex-1 uppercase text-xs">{{row.category}}</p>
            <div class="flex-none text-xs bg-grey text-white rounded-full ml-2 w-6 h-6 flex justify-center items-center">{{row.count}}</div>
          </div>
        </div>
      </div>
      <div class="w-full md:w-1/3 px-3 mt-6">
        <div class="bg-white shadow-md list-group">
          <h2 class="font-dosis font-bold text-lg sm:text-md lg:text-xl bg-purple list-group-item p-4 text-white">Top Oferentes</h2>
          <div class="list-group-item items-center justify-between flex p-4" v-for="row in topBidders">
            <p class="flex-1 uppercase text-xs">{{row.bidder}}</p>
            <div class="flex-none text-xs bg-grey text-white rounded-full ml-2 w-6 h-6 flex justify-center items-center">{{row.count}}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      countries: [],
      topCategories: [],
      topBidders: [],
      topOpportunities: [],
      chartData: null,
      opportunity_count: 0,
      bidder_count: 0,
      enrollment_count: 0,
      candidate_count: 0,
      period: {since: 'first day of last month', until: null}
    };
  },
  mounted() {
    this.load();
  },
  watch: {
    period(value, old) {
      if (
        old.since != value.since ||
        old.until != value.until
      ) {
        this.load();
      }
    }
  },
  methods: {
    async load(draw = true) {
      var stats = await this.$http.get('/admin/stats/dashboard', {
        params: {
          since: this.period.since,
          until: this.period.until
        }
      });

      this.topCategories = stats.data.top_categories;
      this.topOpportunities = stats.data.top_opportunities;
      this.topBidders = stats.data.top_bidders;

      this.candidate_count = stats.data.candidate_count;
      this.opportunity_count = stats.data.opportunity_count;
      this.bidder_count = stats.data.bidder_count;
      this.enrollment_count = stats.data.enrollment_count;

      this.chartData = stats.data.pageviews;
    }
  }
}
</script>
