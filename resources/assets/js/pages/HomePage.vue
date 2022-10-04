<template lang="html">
  <div class="overflow-hidden">
    <component :is="page" :featured="featured" :testimonials="testimonials" :stats="stats" />
  </div>
</template>

<script>
import CandidatePage from './Home/CandidatePage.vue';
import GuestPage from './Home/GuestPage.vue';
import {resolve, http} from '@/plugins/http';

function prefetch(to, next, component = null) {
  return resolve({
    featured() {
      return http.get('/bidders/featured');
    },
    testimonials() {
      return http.get('/testimonials');
    },
  }, next, component);
}

export default {
  components: { CandidatePage, GuestPage },
  data() {
    return {
      // opportunities: {},
      featured: {data: []},
      testimonials: {data: []},
      stats: {
        visits: 0,
        courses: 0,
        users: 0,
      }
    }
  },
  computed: {
    page() {
      return this.$auth.ready() ?
        (this.$auth.check() ? 'candidate-page' : 'guest-page') :
        null;
    }
  },
  beforeRouteEnter (to, from, next) {
    prefetch(to, next).then(http.spread(function (vm, values) {
      vm.stats = {
        visits: 45,
        courses: 23,
        users: 58,
      };
    }));
  },
  beforeRouteUpdate (to, from, next) {
    this.featured = {data: []};
    this.testimonials = {data: []};
    prefetch(to, next, this);
  },

}
</script>

<style lang="scss" scoped>

  .search-box {
    top: 100%;
  }

  @screen xs {
    .slide-caption {
      background: -moz-linear-gradient(left, rgba(0,0,0,.75) 25%, rgba(0,0,0,0) 100%); /* FF3.6-15 */
      background: -webkit-linear-gradient(left, rgba(0,0,0,.75) 25%,rgba(0,0,0,0) 100%); /* Chrome10-25,Safari5.1-6 */
      background: linear-gradient(to right, rgba(0,0,0,.75) 25%,rgba(0,0,0,0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }
  }
</style>
