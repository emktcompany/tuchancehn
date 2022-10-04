<template lang="html">
  <section class="relative pt-32 bg-white">
    <div class="container overflow-hidden">
      <breadcrumbs-list />
      <div class="-mx-8 flex flex-wrap justify-between">
        <div class="px-8 flex-1">
          <h1 class="mt-12 mb-6 text-red font-dosis font-bold">Actualizar información</h1>
          <p class="text-grey-darker mb-12">Completa los campos de información, con lo que puedes también imprimir tu hoja de vida en formato PDF.</p>
        </div>
        <div class="px-8 flex-none" v-if="$auth.check('candidate')">
          <button type="button" @click.prevent="preview=true" class="btn bg-teal text-white">Descargar PDF</button>
          <modal-dialog :shown="preview" @modal-close="preview=false">
            <div class="mb-8">
              <candidate-detail :candidate="$auth.user().candidate" :user="$auth.user()" />
            </div>
            <form class="text-right" target="_blank" action="/cv/download" method="get">
              <input type="hidden" name="token" :value="$auth.token()">
              <button type="submit" class="btn bg-teal text-white">Descargar PDF</button>
            </form>
          </modal-dialog>
        </div>
      </div>
      <component v-bind:is="accountComponent"></component>
    </div>
  </section>
</template>

<script>
import UpdateCandidate from '@/components/account/UpdateCandidate.vue';
import UpdateBidder from '@/components/account/UpdateBidder.vue';
import UpdateUser from '@/components/account/UpdateUser.vue';

export default {
  components: {UpdateCandidate, UpdateBidder, UpdateUser},
  data() {
    return {
      preview: false
    };
  },
  computed: {
    accountComponent() {
      switch (true) {
        case this.$auth.check('candidate'):
          return 'update-candidate';
          break;
        case this.$auth.check('bidder'):
          return 'update-bidder';
          break;
      }

      return 'update-user';
    }
  }
}
</script>
