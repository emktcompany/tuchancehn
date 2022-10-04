<template lang="html">
  <div :class="containerClass" v-if="$auth.ready()">
    <template v-if="!$auth.check()">
      <router-link class="hidden md:block" :class="linkClass" @click.native="click" :to="{name: 'login'}"><span>Entra</span></router-link>
      <router-link class="hidden md:block" :class="linkClass" @click.native="click" :to="{name: 'register.default'}"><span>Regístrate</span></router-link>
    </template>
    <template v-else>
      <router-link :class="linkClass" @click.native="click" :to="{name: 'index'}" class="hidden md:block"><span>Inicio</span></router-link>
      <template v-if="links">
        <router-link class="md:hidden" :class="linkClass" @click.native="click" :to="{name: 'account'}">Perfil</router-link>
        <router-link class="md:hidden" :class="linkClass" @click.native="click" v-if="dashboardLink" :to="dashboardLink">Escritorio</router-link>
        <router-link class="md:hidden" :class="linkClass" @click.native="click" :to="{name: 'settings'}">Configuración</router-link>
        <a href class="md:hidden" :class="linkClass" @click.prevent="logout" v-click-outside="cancel">{{logginOut?'¿Continuar?':'Salir'}}</a>
      </template>
      <user-nav v-else :dashboard-link="dashboardLink" class="hidden sm:block" />
    </template>
  </div>
</template>

<script>
export default {
  props: {
    linkClass: {
      type: String,
      required: true
    },
    containerClass: {
      type: String,
      required: true
    },
    click: {
      type: Function,
      default: () => {}
    },
    links: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      logginOut: false
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
    logout() {
      if (this.logginOut) {
        this.$auth.logout({
          makeRequest: false,
          redirect: '/',
        });
        this.logginOut = false;
        this.click();
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
