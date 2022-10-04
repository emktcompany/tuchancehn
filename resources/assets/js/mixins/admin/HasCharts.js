import Chart from 'chart.js';

export default {
  data() {
    return {
      datasets: [],
      labels: [],
      options: {},
      type: 'line',
    }
  },
  methods: {
    draw(element) {
      new Chart(element.getContext('2d'), {
        type: this.type,
        data: {
          labels: this.labels,
          datasets: this.datasets
        }
      });
    },
    addDataset(label, backgroundColor, borderColor, data, fill = false) {
      this.datasets.push({
        label, data, backgroundColor, borderColor, fill
      })
    }
  }
}
