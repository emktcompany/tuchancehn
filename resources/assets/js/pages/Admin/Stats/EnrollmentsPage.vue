<template lang="html">
  <section>
    <h2 class="text-cyan font-dosis font-bold text-3xl">Oferentes</h2>

    <div class="admin-box">
      <div class="admin-box-inner">
        <div class="flex -mx-4 md:flex-row flex-col text-sm">
          <div class="px-4 flex-1 py-2">
            <p class="mb-2 text-sm text-grey-dark">Filtra tus resultados por</p>
            <div class="flex md:flex-row flex-col -mx-4">
              <div class="py-0 px-4 w-full md:w-1/3 mb-4 md:mb-0">
                <country-select @input="load" v-model="query.country_id" />
              </div>
              <div class="py-0 px-4 w-full md:w-1/3 mb-4 md:mb-0">
                <state-select @input="load" v-model="query.state_id" :country-id="query.country_id" />
              </div>
              <div class="py-0 px-4 w-full md:w-1/3">
                <city-select @input="load" v-model="query.city_id" :country-id="query.state_id" />
              </div>
            </div>
          </div>
          <form-field class="md:border-l border-grey px-4 w-full md:w-1/4" name="period" label="Selecciona un rango de fechas">
            <date-range-picker v-model="period" />
          </form-field>
        </div>
      </div>
    </div>

    <div class="bg-white shadow-lg p-1 md:p-4">
      <base-chart :chart-data="datesChart" />
    </div>
  </section>
</template>

<script>

export default {
  data() {
    return {
      query: {
        dimension: 'day',
        country_id: null,
        state_id: null,
        city_id: null,
      },
      period: {since: 'first day of last month', until: null},
      dimensions: [
        {label: 'Día', value: 'day'},
        {label: 'Mes', value: 'month'},
        {label: 'Año', value: 'year'},
      ],
      datesChart: null
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
      var params = Object.assign({}, this.period, this.query);

      var stats = await this.$http.get('/admin/stats/bidders', {
        params
      });

      this.datesChart = stats.data.dates;
      this.categoriesChart = stats.data.categories;
    },
    setDimension(value) {
      if (this.query.dimension != value.value) {
        this.query.dimension = value.value;
        this.load();
      }
    }
  }
}
</script>
