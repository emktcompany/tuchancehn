export default {
  data() {
    return {
      isMobile: window.innerWidth < 768
    }
  },
  mounted() {
    window.addEventListener("resize", this.onResize, false);
    this.onResize();
  },
  destroyed() {
    window.removeEventListener("resize", this.onResize);
  },
  methods: {
    onResize() {
      this.isMobile = window.innerWidth < 768;
      this.handleResize();
    },
    handleResize() {}
  }
}
