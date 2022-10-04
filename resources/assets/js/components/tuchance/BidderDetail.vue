<template lang="html">
  <div>
    <bidder-preview :bidder="bidder" />
    <div class="mb-8" v-if="bidder.description">
      <p class="mb-2 text-xl font-bold font-dosis">Descripción</p>
      <div class="leading-loose" v-html="bidder.description"></div>
    </div>
    <div class="mb-8" v-if="bidder.services">
      <p class="mb-2 text-xl font-bold font-dosis">Características</p>
      <div class="leading-loose" v-html="bidder.services"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    bidder: {
      type: Object,
      required: true
    }
  }
}
</script>
