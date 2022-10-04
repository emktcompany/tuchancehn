<template lang="html">
  <router-link :to="{name: 'bidder', params: {slug: bidder.slug}}" class="flex flex-col md:flex-row relative h-full text-grey-darker no-underline" v-ripple>
    <div class="flex-none w-48 pb-8 mx-auto md:mx-0 px-4">
      <img :src="bidderImage" alt="Oferente" class="block mx-auto max-w-full h-auto">
    </div>
    <div class="flex-1 pb-8">
      <p class="font-dosis text-2xl text-red mb-4 font-bold">{{ bidder.name }}</p>
      <p class="leading-loose font-thin text-sm mb-4">{{ bidder.summary }}</p>
      <p class="text-lg font-semibold leading-loose"><a href="tel:+50320000000" @click.stop class="text-blue no-underline hover:text-cyan">{{ bidder.phone }}</a></p>
      <p class="text-lg font-semibold leading-loose"><a href="mailto:hola@tuchance.com" @click.stop class="text-blue no-underline hover:text-cyan">{{ bidder.email }}</a></p>
    </div>
  </router-link>
</template>

<script>
export default {
  props: {
    bidder: {
      type: Object,
      required: true
    }
  },
  computed: {
    bidderImage() {
      if (this.bidder.image) {
        return this.bidder.image.url;
      }

      return '/images/bidder-dummy.jpg';
    }
  }
}
</script>
