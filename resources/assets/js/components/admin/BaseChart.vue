<template lang="html">
  <canvas ref="canvas"></canvas>
</template>

<script>
import ChartJS from 'chart.js/dist/Chart.min';
import each from 'lodash/each';

export default {
  props: {
    chartData: {
      default: null,
      type: [Object, null]
    },
    type: {
      default: 'line',
      type: String
    },
    colors: {
      type: Array,
      default: () => ['cyan', 'red', 'teal', 'purple', 'red', 'orange']
    },
    fill: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    this.import();
    this.chart = new ChartJS(this.$refs.canvas.getContext('2d'), {
      type: this.type,
      data: {
        labels: this.labels,
        datasets: this.datasets
      }
    });
  },
  watch: {
    chartData() {
      this.import();
    }
  },
  data() {
    return {
      labels: [],
      datasets: [],
      chart: null
    };
  },
  methods: {
    update() {
      if (this.chart) {
        this.chart.data.labels = this.labels;
        this.chart.data.datasets = this.datasets;
        this.chart.update();
      }
    },
    addDataset(label, data, backgroundColor, borderColor, fill = false) {
      this.datasets.push({label, data, backgroundColor, borderColor, fill});
    },
    import() {
      this.datasets = [];

      if (this.chartData) {
        each(this.chartData.datasets, (data, label) => {
          var j = this.datasets.length;
          var backgroundColor = this.colors[j] || 'grey';
          var borderColor     = this.colors[j] || 'grey';
          this.addDataset(label, data, backgroundColor, borderColor, this.fill);
        });

        this.labels = this.chartData.labels || [];
      } else {
        this.labels = [];
      }

      this.update();
    }
  }
}
</script>
