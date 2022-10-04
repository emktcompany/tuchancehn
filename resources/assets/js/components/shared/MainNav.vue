<template lang="html">
  <nav v-show="show" class="fixed pin z-20 overflow-hidden">
    <div class="relative h-full container">
      <transition name="dot"
        leave-active-class="transition-duration-short transition-delayed">
        <div v-show="showBackground" class="bg-purple absolute nav-bg dot transition-duration-short" :style="navBgStyles"></div>
      </transition>
      <transition name="dot"
      @after-enter="onBackgroundShown"
      @after-leave="onBackgroundHidden"
      enter-active-class="transition-duration-short transition-delayed">
        <div v-show="showBackground" class="bg-cyan absolute close-bg dot" :style="closeBgStyles"></div>
      </transition>
      <div class="relative h-full flex flex-col justify-between">
        <div class="flex items-center h-24 flex-none relative z-10">
          <div class="flex-none">
            <router-link :to="{ name: 'index' }" class="block text-white" @click.native="hide"><svg-icon class="fill-current" src="~@svg/tuchance.svg"></svg-icon></router-link>
          </div>
          <div class="flex-1 flex justify-end items-center">
            <div class="flex-none pr-4 md:hidden">
              <transition name="slideFadeDown">
                <country-menu @country-selected="showElements = false" v-if="showElements" />
              </transition>
            </div>
            <div class="flex-none w-6">
              <transition
                @after-leave="onElementsHidden"
                enter-active-class="animated rotateIn"
                leave-active-class="animated rotateOut">
                <a v-show="showElements" href @click.prevent="hide" class="no-underline block text-white"><svg-icon class="stroke-current" src="~@svg/close-icon.svg"></svg-icon></a>
              </transition>
            </div>
          </div>
        </div>
        <div class="flex-1 relative">
          <div class="relative min-h-full flex items-center justify-between">
            <div class="flex-1">
              <transition
                enter-active-class="animated fadeInLeft"
                leave-active-class="animated fadeOutLeft">
                <nav class="main-nav" v-show="showElements">
                  <router-link @mouseenter.native="makeIndicator($event)" :to="{name: 'index'}" @click.native="hide"><span>Inicio</span></router-link>
                  <router-link @mouseenter.native="makeIndicator($event)" :to="{name: 'about'}" @click.native="hide"><span>¿Quiénes Somos?</span></router-link>
                  <router-link @mouseenter.native="makeIndicator($event)" :to="{name: 'opportunities'}" @click.native="hide"><span>Oportunidades</span></router-link>
                  <router-link @mouseenter.native="makeIndicator($event)" :to="{name: 'bidders'}" @click.native="hide"><span>Oferentes</span></router-link>
                  <router-link @mouseenter.native="makeIndicator($event)" :to="{name: 'category', params: {category: 'cursos-en-linea'}}" @click.native="hide"><span>Cursos Online</span></router-link>
                  <div class="md:hidden" v-if="$auth.check()">
                    <hr class="border-t border-grey-light">
                    <router-link :to="{name: 'account'}" @click.native="hide"><span><svg-icon src="~@svg/profile-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> Perfil</span></router-link>
                    <router-link v-if="dashboardLink" :to="dashboardLink" @click.native="hide"><span><svg-icon src="~@svg/icons/regular/bookmark.svg" class="fill-current h-4 w-4 mr-3"/> {{$auth.check('candidate')?'Mis Oportunidades':'Escritorio'}}</span></router-link>
                    <router-link :to="{name: 'settings'}" @click.native="hide"><span><svg-icon src="~@svg/settings-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> Configuración</span></router-link>
                    <a href @click.prevent="logout" v-click-outside="cancel"><span><svg-icon src="~@svg/signout-icon.svg" class="stroke-current fill-none h-4 w-4 mr-3"/> {{logginOut?'¿Continuar?':'Salir'}}</span></a>
                  </div>
                  <div class="md:hidden" v-else>
                    <hr class="border-t border-grey-light">
                    <router-link class="hidden md:block" @click.native="hide" :to="{name: 'login'}"><span>Entra</span></router-link>
                    <router-link class="hidden md:block" @click.native="hide" :to="{name: 'register.default'}"><span>Regístrate</span></router-link>
                  </div>
                </nav>
              </transition>
            </div>
            <div class="flex-none w-1/2 hidden md:block">
              <transition
                enter-active-class="animated fadeInRight"
                leave-active-class="animated fadeOutRight">
                <img v-show="showElements" src="~@img/menu-talent.jpg" alt="TuChance">
              </transition>
            </div>
          </div>
        </div>
        <div class="flex-none text-white">
          <transition
            enter-active-class="animated slideInUp"
            leave-active-class="animated slideOutDown">
            <div v-show="showElements" class="flex flex-col md:flex-row py-4 md:py-12 justify-between items-center text-xs sm:text-sm">
              <p class="mb-2 md:mb-0 text-center md:text-left">Tu Chance &copy; 2018 Todos los derechos reservados</p>
              <p>
                <router-link @click.native="hide" :to="{ name: 'impressum' }" class="text-white no-underline hover:text-grey-lighter">Impressum</router-link> |
                <router-link @click.native="hide" :to="{ name: 'terms' }" class="text-white no-underline hover:text-grey-lighter">Términos y condiciones</router-link>
              </p>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import {getPosition} from '@/lib/position';

const NAV_BG_SIZE   = 3;
const CLOSE_BG_SIZE = .4;

export default {
  props: {
    show: {
      required: true,
      type: Boolean
    }
  },
  data() {
    return {
      logginOut: false,
      showBackground: !!this.show,
      showElements: !!this.show,
      navBgStyles: this.calcDotStyles(NAV_BG_SIZE),
      closeBgStyles: this.calcDotStyles(CLOSE_BG_SIZE),
      indicatorStyles: {width: '0px', top: '0px'},
      indicatorTimeout: null
    }
  },
  mounted() {
    window.addEventListener("resize", this.onResize, false);
  },
  destroyed() {
    window.removeEventListener("resize", this.onResize);
  },
  watch: {
    show(value) {
      if (value) {
        this.showBackground = true;
      }
    }
  },
  computed: {
    dashboardLink() {
      switch (true) {
        case this.$auth.check('admin'):
        case this.$auth.check('bidder'):
          return {name: 'admin.dashboard'};
          break;
        case this.$auth.check('candidate'):
          return {name: 'my-opportunities'};
          break;
      }

      return null;
    }
  },
  methods: {
    hide() {
      this.showElements = false;
    },
    onBackgroundShown() {
      this.showElements = true;
    },
    onBackgroundHidden() {
      this.$emit('hide-nav');
    },
    onElementsHidden() {
      this.showBackground = false;
    },
    makeIndicator($event) {
      var $elem     = $event.target;
      var $position = getPosition($elem);
      var $text     = $elem.querySelector('span');
      var indicator = {
        top: String($position.y + $elem.offsetHeight) + 'px',
        width: String($position.x + $text.offsetWidth) + 'px'
      };


    },
    onResize() {
      this.navBgStyles = this.calcDotStyles(NAV_BG_SIZE);
      this.closeBgStyles = this.calcDotStyles(CLOSE_BG_SIZE);
    },
    calcDotStyles(factor) {
      var size = Math.max(window.innerWidth, window.innerHeight) * factor;
      return {
        width: (size) + 'px',
        marginLeft: '-' + String((size / 2) + 27) + 'px',
        marginTop: '-' + String((size / 2) - 48) + 'px'
      };
    },
    logout() {
      if (this.logginOut) {
        this.$auth.logout({
          makeRequest: false,
          redirect: '/',
        });
        this.logginOut = false;
        this.hide();
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
  .nav-bg, .close-bg {
    top: 0;
    left: 100%;
  }
  .indicator {
    transition: width .25s ease;
  }

  .main-nav {
    a {
      @apply text-xl text-white block font-dosis py-2 no-underline ;

      &:hover {
        @apply text-grey-lighter;
      }

      @screen sm {
        @apply text-3xl ;
      }

      @screen md {
        @apply py-3 text-4xl ;
      }

      @screen lg {
        @apply py-4 text-5xl ;
      }
    }
  }
</style>
