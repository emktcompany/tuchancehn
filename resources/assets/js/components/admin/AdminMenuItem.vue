<template lang="html">
  <li class="flex flex-wrap" v-if="available" v-click-outside="close">
    <router-link class="flex-1 truncate block no-underline" :class="active ? activeClass : linkClass" @click.native="$emit('clicked')" :to="link.route">
      <svg-icon v-if="link.icon" :source="link.icon" class="w-3 h-3 mr-2 fill-current" />
      {{ link.label }}
    </router-link>
    <template v-if="hasChildren">
      <button v-collapse-toggle="'submenu'" class="flex-none text-2xs py-2 w-8 outline-none focus:outline-none" :class="moreClass">&#x25BC;</button>
      <v-collapse-wrapper ref="submenu" class="w-full">
        <ul class="list-reset" v-collapse-content>
          <admin-menu-item @clicked="$emit('clicked')" v-for="(sublink, i) in link.children" :key="`sublink-${i}`" :link="sublink" />
        </ul>
      </v-collapse-wrapper>
    </template>
  </li>
</template>

<script>
import find from 'lodash/find';
import map from 'lodash/map';
import keys from 'lodash/keys';
import each from 'lodash/each';

export default {
  props: {
    link: {
      required: true,
      type: Object
    },
    linkClass: {
      type: String,
      default: 'bg-grey-light text-grey-darker hover:text-white hover:bg-cyan p-3'
    },
    activeClass: {
      type: String,
      default: 'text-white bg-cyan p-3'
    },
    moreClass: {
      type: String,
      default: 'hover:bg-grey bg-grey-light text-grey-darker'
    }
  },
  computed: {
    hasChildren() {
      return this.link.children && this.link.children.length;
    },
    active() {
      return this.activeInChildren || this.current;
    },
    hasSameParams() {
      var paramNames = keys(this.$route.params || {});

      if (!paramNames.length) {
        return true;
      }

      return !!paramNames.filter((key) => {
        return this.$route.params[key] == this.link.route.params[key];
      }).length;
    },
    current() {
      return this.link.route.name == this.$route.name && this.hasSameParams;
    },
    activeInChildren() {
      return !!(this.hasChildren &&
        find(map(this.link.children, 'route'), {name: this.$route.name}));
    },
    available() {
      if (!this.link.check) {
        return true;
      }

      if (this.link.check.except) {
        return !this.$auth.check(this.link.check.except, 'roles');
      }

      if (this.link.check.only) {
        return this.$auth.check(this.link.check.only, 'roles');
      }

      return false;
    }
  },
  watch: {
    'link.children'() {
      this.openIfActive();
    },
  },
  mounted() {
    this.openIfActive();
  },
  methods: {
    close() {
      this.$refs.submenu && this.$refs.submenu.close()
    },
    openIfActive() {
      if (this.active) {
        this.$refs.submenu && this.$refs.submenu.open()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
