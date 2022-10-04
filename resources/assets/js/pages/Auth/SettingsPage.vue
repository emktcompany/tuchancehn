<template lang="html">
  <section class="relative pt-32 bg-white">
    <div class="container overflow-hidden">
      <breadcrumbs-list />
      <div class="-mx-8 flex flex-wrap justify-between">
        <div class="px-8 flex-1">
          <h1 class="mt-12 mb-6 text-red font-dosis font-bold">Actualizar información</h1>
          <p class="text-grey-darker mb-12">Completa los campos de información.</p>
        </div>
      </div>
      <component v-bind:is="accountComponent"></component>
    </div>
  </section>
</template>

<script>
import SettingsCandidate from '@/components/account/SettingsCandidate.vue';
import SettingsBidder from '@/components/account/SettingsBidder.vue';
import SettingsUser from '@/components/account/SettingsUser.vue';

export default {
  components: {SettingsCandidate, SettingsBidder, SettingsUser},
  computed: {
    accountComponent() {
      switch (true) {
        case this.$auth.check('candidate'):
          return 'settings-candidate';
          break;
        case this.$auth.check('bidder'):
          return 'settings-bidder';
          break;
      }

      return 'settings-user';
    }
  }
}
</script>
