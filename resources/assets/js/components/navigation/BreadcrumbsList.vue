<template lang="html">
  <nav class="xs:text-sm">
    <router-link class="no-underline" :to="item.link" :key="i" v-for="(item, i) in links">
      <span :class="i != links.length - 1 ? 'text-red font-bold' : textColor">{{item.name}}</span>
      <span class="mx-1" :class="textColor" v-if="i != links.length - 1"> / </span>
    </router-link>
  </nav>
</template>

<script>
import filter from 'lodash/filter';
import map from 'lodash/map';
import each from 'lodash/each';

export default {
  props: {
    textColor: {
      type: String,
      default: 'text-grey-dark'
    }
  },
  data() {
    return {
      links: []
    }
  },
  watch: {
    $route() {
      this.calcBreadcrumbs();
    }
  },
  created() {
    setTimeout(this.calcBreadcrumbs, 100);
  },
  methods: {
    calcBreadcrumbs() {
      this.links = [{
        name: 'Inicio',
        link: {name: 'index'}
      }];

      each(this.$route.matched, (route) => {
        this.makeBreadCrumb(route);
      });
    },
    makeBreadCrumb(route) {
      var meta = route.meta || {};
      var name = meta.title || false;
      var parent;
      var route_name;

      if (meta.parent) {
        parent = this.$router.resolve({
          name: meta.parent,
          params: this.$route.params
        });

        this.makeBreadCrumb(parent.route);
      }

      if (name) {
        if (typeof name == 'function') {
          name = name.call(this.$parent);
        }

        if (meta.route) {
          route_name = meta.route;
        } else {
          route_name = route.name;
        }

        this.links.push({
          name,
          link: {name: route_name, params: this.$route.params}
        });
      };
    }
  }
}
</script>
