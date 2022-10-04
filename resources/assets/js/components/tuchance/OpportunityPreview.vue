<template lang="html">
  <article class="bg-grey-lighter flex relative h-full" v-ripple>
    <router-link :to="link" class="relative h-full flex flex-col cursor-pointer group no-underline block w-full">
      <figure class="m-0 flex-none bg-no-repeat bg-center bg-cover" :style="background"></figure>
      <div class="p-4 flex-grow flex flex-col">
        <p class="text-lg mb-4 font-dosis text-grey-darker flex-grow">{{ opportunity.name }}</p>
        <div class="flex-none">
          <!-- <p class="mb-4 text-grey-dark text-xs text-justify leading-normal" v-if="!opportunity.finish_at ">
            {{ opportunity.summary }}
          </p> -->
          <p class="mb-4 text-grey-dark text-xs">
            <span v-if="opportunity.finish_at">Valido hasta {{ opportunity.finish_at | date('DD/MMM/YYYY') }}</span>
            &nbsp;
          </p>
          <p class="mb-4 text-grey-dark text-xs">
            <span v-if="opportunity.state">{{ opportunity.state.name }} &bull;</span>
            <span v-if="opportunity.city">{{ opportunity.city.name }}</span>
            &nbsp;
          </p>
          <div class="flex justify-between items-center">
            <div></div>
            <div class="text-grey-dark flex-none rounded-full bg-grey-light"><svg-icon class="stroke-current block" src="~@svg/next-icon.svg" /></div>
          </div>
        </div>
      </div>
    </router-link>
    <div class="p-4 pin-b pin-l absolute"><category-pill :id="opportunity.category_id" /></div>
  </article>
</template>

<script>
import find from 'lodash/find';

var image = require('@img/opportunity-dummy.jpg');

export default {
  props: {
    opportunity: {
      type: Object,
      required: true
    }
  },
  computed: {
    link() {
      return {
        name: 'opportunity',
        params: {slug: this.opportunity.slug}
      };
    },
    image() {
      if (this.opportunity.image) {
        return this.opportunity.image.url;
      }

      if (this.category.opportunity) {
        return this.category.opportunity.url;
      }

      return image;
    },
    category() {
      return find(this.$categories, {id: this.opportunity.category_id});
    },
    background() {
      return {
        backgroundImage: `url(${this.image})`
      }
    }
  }
}
</script>

<style scoped>
  figure {
    padding-bottom: 57%;
    height: 0px;
    overflow: hidden;
  }
</style>
