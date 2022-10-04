<template lang="html">
  <main class="flex flex-col min-h-screen">
    <template v-if="$country && $categories.length">
      <main-header @show-nav="showNav" class="fixed pin-x pin-t h-24 z-10 main-header"></main-header>
      <main-nav @hide-nav="hideNav" :show="isNavShown"></main-nav>
      <router-view class="flex-grow main-content"></router-view>
      <main-footer class="flex-none main-footer"></main-footer>
      <notification-center class="fixed pin-b pin-l notification-center"></notification-center>
    </template>
    <loading-spinner class="z-50" :mount-open="true"></loading-spinner>
    <modal-dialog padding="p-0" theme="bg-blue text-white" width="max-w-md" :shown="invitation" @modal-close="invitation=false">
      <div class="flex flex-wrap">
        <div class="w-full sm:w-2/3 p-4 sm:p-8">
          <h3 class="text-orange font-dosis text-4xl mb-6">¡Rétate a crecer!</h3>
          <p class="mb-6">Al registrarte, tendrás muchas oportunidades de empleo, educación o becas, especiales para tí.</p>
          <div class="text-center">
            <router-link @click.native="invitation=false" :to="{name: 'login'}" class="btn bg-teal text-white block sm:inline-block sm:mr-4 mb-3">Iniciar sesión</router-link>
            <router-link @click.native="invitation=false" :to="{name: 'register.default'}" class="btn bg-teal text-white block sm:inline-block sm:mr-4 mb-3">Registrate</router-link>
          </div>
        </div>
        <div class="bg-cover bg-center bg-no-repeat hidden sm:block sm:w-1/3" :style="style"></div>
      </div>
    </modal-dialog>
  </main>
</template>

<script>
import MainNav from './shared/MainNav.vue';
import MainHeader from './shared/MainHeader.vue';
import MainFooter from './shared/MainFooter.vue';

let timeout;

export default {
  components: {MainHeader, MainFooter, MainNav},
  data() {
    return {
      isNavShown: false,
      invitation: false,
      wasShown: false
    }
  },
  watch: {
    $loggedIn(value, old) {
      clearTimeout(timeout);

      if (!value) {
        this.setTimer();
      }
    }
  },
  computed: {
    style() {
      return {
        backgroundImage: 'url(' + require('@img/menu-talent.jpg') + ')'
      }
    }
  },
  created() {
    clearTimeout(timeout);

    if (!this.$loggedIn) {
      this.setTimer();
    }
  },
  methods: {
    setTimer() {
      timeout = setTimeout(() => {
        if (!this.wasShown && !/^register\./.test(this.$route.name)) {
          this.invitation = true;
        }

        this.wasShown = true;
      }, 3 * 60 * 1000);
    },
    showNav () {
      document.documentElement.style.overflow = 'hidden';
      this.isNavShown = true;
    },
    hideNav () {
      document.documentElement.style.overflow = '';
      this.isNavShown = false;
    }
  }
}
</script>
