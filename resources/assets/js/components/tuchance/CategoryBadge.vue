<template lang="html">
  <component :is="component" :href="category.link" :target="target" :to="link" v-ripple  class="block m-3 lg:m-4 w-40 h-40 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full flex flex-col items-center justify-center text-white no-underline text-sm md:text-xs lg:text-sm p-4 text-center cursor-pointer" :class="`bg-${category.color}`">
    <img :src="category.image.url" class="block mx-auto mb-2" />
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
