<template lang="html">
  <div class="relative z-10" v-click-outside="hideUserNav" v-if="$country">
    <a href @click.prevent="toggleUserNav" class="text-white px-6 py-4 no-underline uppercase flex items-center leading-none align-middle whitespace-no-wrap hover:text-grey-lighter">
      <div class="relative">
        <div class="absolute pin-y pin-x flex items-center">
          <img :src="avatar" alt="" class="h-8 w-8 rounded-full border-2 border-white">
        </div>
        <div class="pl-12">
          ¡Hola {{$user.first_name}}! <span class="inline-block ml-4"><svg-icon class="fill-current block" src="~@svg/dropdown-icon.svg"></svg-icon></span>
        </div>
      </div>
    </a>
    <transition name="slideFadeDown">
      <div v-show="showUserNav" class="dropdown-menu min-w-full absolute pin-l bg-purple py-2 shadow-lg rounded-b-lg font-light z-50">
        <router-link @click.native="hideUserNav" :to="{name: 'account'}"><svg-icon src="~@svg/profile-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> Perfil</router-link>
        <router-link @click.native="hideUserNav" v-if="dashboardLink" :to="dashboardLink"><svg-icon src="~@svg/icons/regular/bookmark.svg" class="fill-current h-4 w-4 mr-3"/> {{$auth.check('candidate')?'Mis Oportunidades':'Escritorio'}}</router-link>
        <router-link @click.native="hideUserNav" :to="{name: 'settings'}"><svg-icon src="~@svg/settings-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> Configuración</router-link>
        <a href @click.prevent="logout" v-click-outside="cancel"><svg-icon src="~@svg/signout-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> {{logginOut?'¿Continuar?':'Salir'}}</a>
      </div>
    </transition>
  </div>
</template>

<script>
var avatar = require('@img/default-avatar.png');
export default {
  props: {
    dashboardLink: {
      default: null
    }
  },
  data() {
    return {
      logginOut: false,
      showUserNav: false
    }
  },
  computed: {
    avatar() {
      var user_avatar = this.$user.avatar || {};
      return user_avatar.url || avatar;
    }
  },
  methods: {
    toggleUserNav() {
      this.showUserNav = !this.showUserNav;
    },
    hideUserNav() {
      this.showUserNav = false;
    },
    logout() {
      if (this.logginOut) {
        this.$auth.logout({
          makeRequest: false,
          redirect: '/',
        });
        this.logginOut = false;
        this.hideUserNav();
      } else {
        this.logginOut = true;
      }
    },
    cancel(){
      this.logginOut = false;
    }
  }
}
</script>

<style lang="scss" scoped>
  .dropdown-menu {
    top: 100%;

    a {
      @apply px-6 block no-underline py-3 text-white whitespace-no-wrap ;

      &:hover {
        @apply text-grey-lighter bg-purple-dark ;
      }
    }
  }
</style>
