<template lang="html">
  <component :is="component" :href="category.link" :target="target" :to="link" v-ripple class="rounded-xl flex items-center no-underline text-white px-2 py-1 text-xs" :class="pillClass">
    <img :src="category.image.url" class="block mr-2 w-4" />
    {{ category.name }}
  </component>
</template>

<script>
import find from 'lodash/find';

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  computed: {
    component() {
      return !this.category.link ? 'router-link' : 'a';
    },
    category() {
      return find(this.$categories, {id: this.id});
    },
    pillClass() {
      return `bg-${this.category.color}`;
    },
    target() {
      return this.category.link ? '_blank' : '_self';
    },
    link() {
      return {
        name: 'category',
        params: {category: this.category.slug}
      };
    }
  }
}
</script>
