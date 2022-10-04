<template lang="html">
  <section class="relative pt-32">
    <div class="container">
      <div class="flex flex-col md:flex-row justify-between md:pt-12 pb-12">
        <div class="w-full md:w-1/2 py-8 text-center md:text-left">
          <breadcrumbs-list text-color="text-white" />
          <div class="font-dosis text-5xl lg:text-6xl text-white pt-4 md:pt-24 text-shadow-dense md:text-shadow-none">
            <div>Es tu momento.</div>
            <div>Es tu decisión.</div>
            <div>¡Comienza hoy!</div>
          </div>
          <div class="text-2xl text-cyan font-thin mb-4">Crear cuenta como:</div>
          <div class="md:pb-32 sm:text-2xl">
            <div class="inline-block">
              <div class="inline-block p-4 bg-blue-dark rounded-2xl type-links relative">
                <div class="absolute rounded-2xl bg-orange indicator ml-4 mt-4 transition" :style="indicatorStyle"></div>
                <div class="relative font-bold">
                  <router-link ref="candidate" :to="{ name: 'register.candidate' }" class="no-underline relative inline-block py-4 px-5 type-link transition" :class="$route.name == 'register.candidate' ? 'text-blue-dark hover:text-blue' : 'text-orange hover:text-white'">Usuario</router-link>
                  <router-link ref="bidder" :to="{ name: 'register.bidder' }" class="no-underline relative inline-block py-4 px-5 type-link transition" :class="$route.name == 'register.bidder' ? 'text-blue-dark hover:text-blue' : 'text-orange hover:text-white'">Oferente</router-link>
                </div>
              </div>
              <div class="text-lg text-white text-center font-thin mt-4">{{$route.name == 'register.bidder' ? '(Ofrezco Oportunidades)' : ($route.name == 'register.candidate' ? '(Busco Oportunidades)' : '')}}</div>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/2 flex justify-center">
          <div class="w-full max-w-xs p-6 md:p-10 lg:p-12 bg-white flex h-full relative flex-col">
            <div class="flex-none font-dosis font-bold text-3xl text-purple mb-6">Regístrate</div>
            <div class="flex-1 relative transition" :class="formClass" :style="formStyles">
              <transition
                mode="out-in"
                enter-active-class="animated fadeInLeft"
                leave-active-class="animated fadeOutRight">
                <router-view/>
              </transition>
            </div>
            <p class="mt-6 text-center flex-none">Haciendo click en continuar, aceptas los<br>
              <router-link class="no-underline text-red" :to="{ name: 'terms' }">Términos y condiciones</router-link></p>

            <p class="mt-6 text-sm text-center flex-none">
              ¿Ya posees una cuenta?
              <router-link :to="{name: 'login'}" class="text-grey-dark">Inicia Sesión</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return{
      indicatorStyle: {},
      formStyles: {},
      formClass: ''
    };
  },
  watch: {
    $route(to) {
      this.repositionIndicator(to);
    }
  },
  mounted() {
    setTimeout(this.onResize, 300);
    window.addEventListener('resize', this.onResize, false);
  },
  destroyed() {
    window.removeEventListener('resize', this.onResize);
  },
  methods: {
    onResize() {
      setTimeout(() => {
        this.repositionIndicator(this.$route)
      }, 100);
    },
    repositionIndicator(to) {
      var ref  = to.name.match(/^register\.(bidder|candidate)$/);
      var $ref;
      var $el;

      if (ref && ref[1]) {
        $ref = this.$refs[ref[1]];
        $el  = $ref ? $ref.$el : null;
        this.indicatorStyle = {
          height: `${$el.offsetHeight}px`,
          width: `${$el.offsetWidth}px`,
          left: `${$el.offsetLeft}px`,
          top: `${$el.offsetTop}px`,
        };
        this.formStyles = {height: ref[1] == 'candidate' ? '647px' : '828px'};
        this.formClass  = '';
      } else {
        $ref = this.$refs['candidate'];
        $el  = $ref ? $ref.$el : null;
        this.indicatorStyle = {
          height: `${$el.offsetHeight}px`,
          width: `0px`,
          left: `${$el.offsetLeft}px`,
          top: `${$el.offsetTop}px`,
        };
        this.formStyles = {height: '520px'};
        this.formClass  = 'flex items-center justify-center';
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .transition {
    transition: all .25s ease;
  }
</style>
