<template lang="html">
  <div class="px-4">
    <a href @click.prevent="preview=true" class="btn bg-teal text-white">Previsualizar</a>
    <modal-dialog width="max-w-md" :shown="preview" @modal-close="preview=false">
      <h3 class="text-orange font-dosis text-3xl pb-2 border-b border-red mb-6">Previsualización de correo</h3>

      <div class="bg-white px-4 pt-4" :class="{'pb-4': !opening}">
        <div>
          <img src="@img/email-logo.png" width="173" height="48">
        </div>
        <div class="flex justify-end text-white">
          <div class="w-full sm:w-3/5 flex">
            <div class="bg-purple w-1/2 sm:rounded-l py-3 uppercase text-center text-sm">Oportunidades</div>
            <div class="bg-red w-1/2 sm:rounded-r py-3 uppercase text-center text-sm">Oferentes</div>
          </div>
        </div>
      </div>
      <div class="px-4 pb-4" v-if="opening">
        <img :src="opening" class="w-full h-auto block" alt="">
      </div>

      <div class="text-purple text-xl mb-4 mt-4 px-4">
        <p>Es el día de encontrar oportunidades</p>
      </div>

      <div class="p-4 text-sm" v-for="line in row.content">
        <div>{{line}}</div>
      </div>

      <div v-if="row.cta && row.cta_text" class="p-4">
        <button class="bg-red px-4 text-white uppercase py-2" style="border-radius:30px">
          {{row.cta_text}}
        </button>
      </div>

      <div class="bg-white p-4">
        <div class="flex items-center -mx-4">
          <div class="px-4 flex-none whitespace-no-wrap">
            <p class="text-xs">Ponte en contacto<br />con nostros</p>
            <p class="mt-4 text-blue text-sm">
              (503) 2000 - 0000
            </p>
            <p class="text-blue text-sm">
              hola@tuchance.com
            </p>
          </div>
          <div class="px-4 flex-none">
            <p class="text-red text-xs whitespace-no-wrap">Desarrollado por:</p>
          </div>
          <div class="px-4 flex-1">
            <img src="@img/email-sponsors.png" alt="">
          </div>
          <div class="px-4">
            <nav class="flex flex-row -mx-1 mt-4">
              <a href="https://facebook.com" target="_blank" class="social-link facebook mx-1 text-white hover:text-grey-lighter">
                <svg-icon src="~@svg/facebook.svg" class="fill-current"></svg-icon>
              </a>
              <a href="https://youtube.com" target="_blank" class="social-link youtube mx-1 text-white hover:text-grey-lighter">
                <svg-icon src="~@svg/youtube.svg" class="fill-current"></svg-icon>
              </a>
            </nav>
          </div>
        </div>
      </div>
      <div style="background:#0C5B70" class="text-center">
        <img :src="closing" class="block mx-auto" alt="">
      </div>
      <div class="bg-purple justify-between text-white p-4">
        <div class="flex items-center -mx-4">
          <div class="px-4">
            <img src="@img/email-footer-logo.png" alt="">
          </div>
          <div class="px-4 text-center text-xs">
            Tu Chance &copy; 2018 Todos los derechos reservados
          </div>
          <div class="px-4 text-right text-sm">
            Unsubscribe
          </div>
        </div>
      </div>
    </modal-dialog>
  </div>
</template>

<script>
export default {
  props: {
    row: {
      type: Object,
      require: true
    }
  },
  watch: {
    row(value, old) {
      this.readFile(value.sponsor, 'sponsors', require('@img/email-sponsors.png'));
      this.readFile(value.footer, 'closing', require('@img/email-closing.png'));
      this.readFile(value.banner, 'opening', null);
    }
  },
  data () {
    return {
      opening: null,
      sponsors: require('@img/email-sponsors.png'),
      closing: require('@img/email-closing.png'),
      preview: false
    }
  },
  methods: {
    readFile(file, data, defaultValue) {
      if (file && typeof FileReader === 'function') {
        if (file.type && file.type.includes('image/')) {
          var reader = new FileReader;
          reader.onload = (event) => {
            this[data] = event.target.result;
          };
          reader.readAsDataURL(file);
          return;
        }
      }

      this[data] = defaultValue;
    }
  }
}
</script>
<style lang="scss" scoped>
  .social-link {
    @apply rounded-full w-8 h-8 flex items-center justify-center ;

    &.facebook {
      background: #3B5998;

      &:hover {
        background: lighten(#3B5998, 5%)
      }
    }
    &.youtube {
      background: #E52D27;

      &:hover {
        background: lighten(#E52D27, 5%)
      }
    }
  }
</style>
