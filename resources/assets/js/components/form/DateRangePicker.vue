<template lang="html">
  <div class="date-range-picker">
    <div v-show="select">
      <v-select class="form-field" label="label" v-model="selected" :options="periods" :clear-search-on-select="false" @input="onSelected">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </div>
    <div class="relative" v-show="!select">
      <input class="form-field" ref="flatpickr">
      <a href @click.prevent="showPeriod" class="pin-r pin-y flex px-4 no-underline text-grey-dark hover:text-purple flex items-center absolute">
        <svg-icon src="~@svg/icons/solid/times.svg" class="fill-current w-3 h-3" />
      </a>
    </div>
  </div>
</template>

<script>
import find from "lodash/find";
import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";

var pickr;

export default {
  props: {
    value: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      select: true,
      selected: null,
      periods: [
        {label: 'Últimos 7 días', value: '7 days ago'},
        {label: 'Este mes', value: 'first day of this month'},
        {label: 'El mes pasado', value: 'first day of last month'},
        {label: 'Todo el tiempo', value: null},
        {label: 'Personalizado', value: false}
      ]
    };
  },
  created() {
    if (this.value.since) {
      this.selected = find(this.periods, {value: this.value.since});

      if (this.value.until) {
        // to do preselect range
      } else {
        this.onSelected(this.selected);
      }
    } else if (!this.value.until) {
      this.reset();
    }
  },
  mounted() {
    pickr = flatpickr(this.$refs.flatpickr, {
      mode: "range",
      maxDate: "today",
      dateFormat: "Y-m-d",
      locale: Spanish,
      onChange: (dates, datestr, instance) => {
        if (dates.length == 2) {
          this.$emit('input', {
            since: instance.formatDate(dates[0], 'Y-m-d'),
            until: instance.formatDate(dates[1], 'Y-m-d'),
          })
        }
      }
    });
  },
  methods: {
    reset() {
      this.selected = this.periods[0];
      this.onSelected(this.selected);
    },
    onSelected(option) {
      var until = null;

      if (!(option.value === false)) {
        this.period = option.value;

        if (this.period == 'first day of last month') {
          until = 'last day of last month';
        }

        this.$emit('input', {since: this.period, until});
      } else {
        this.select = false;
        setTimeout(() => {
          pickr.open();
        }, 50);
      }
    },
    showPeriod() {
      this.select = true;
      this.selected = this.periods[0];
      this.onSelected(this.selected);
      pickr.setDate(null, true);
    }
  }
}
</script>

<style lang="scss">
.date-range-picker .v-select .dropdown-toggle .clear { visibility: hidden; }
</style>
