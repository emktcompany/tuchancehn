<template lang="html">
  <footer class="border-t border-cyan">
    <div class="flex flex-col md:flex-row container md:items-center justify-between py-12">
      <div class="flex-none pr-12 lg:pr-24 mb-8 md:mb-0">
        <p class="text-lg font-thin leading-none mb-2">Ponte en contacto<br>con nostros</p>
        <p class="text-lg font-semibold leading-loose"><a href="tel:+50320000000" class="text-blue no-underline hover:text-cyan">(503) 2000 - 0000</a></p>
        <p class="text-lg font-semibold leading-loose"><a href="mailto:hola@tuchance.com" class="text-blue no-underline hover:text-cyan">hola@tuchance.com</a></p>
        <nav class="flex flex-row -mx-1 mt-4">
          <a href="https://facebook.com" target="_blank" class="social-link facebook mx-1 text-white hover:text-grey-lighter">
            <svg-icon src="~@svg/facebook.svg" class="fill-current"></svg-icon>
          </a>
          <a href="https://youtube.com" target="_blank" class="social-link youtube mx-1 text-white hover:text-grey-lighter">
            <svg-icon src="~@svg/youtube.svg" class="fill-current"></svg-icon>
          </a>
        </nav>
      </div>
      <div class="flex-1 flex flex-col md:flex-row items-center justify-end">
        <p class="text-red text-xl font-dosis font-semibold whitespace-no-wrap mb-8 md:mb-0">Desarrollado por:</p>
        <div class="flex">
          <div class="md:pl-12 lg:pl-24 pr-12">
            <a href="https://www.fundaciongloriakriete.org/" target="_blank"><img src="~@img/gloria-kriete.png" alt="Fundación Gloria Kriete" width="73" height="100" class="block"></a>
          </div>
          <div>
            <a href="https://www.giz.de/en/worldwide/391.html" target="_blank"><img src="~@img/giz.png" alt="Cooperación Alemana | GIZ" width="260" height="100" class="block"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-purple py-2 text-sm">
      <div class="container flex flex-col sm:flex-row sm:justify-between justify-center items-center text-white">
        <p>Tu Chance © 2018 Todos los derechos reservados</p>
        <p>
          <router-link class="text-white hover:text-grey-lighter no-underline" :to="{ name: 'impressum' }">Impressum</router-link> |
          <router-link class="text-white hover:text-grey-lighter no-underline" :to="{ name: 'terms' }">Términos y condiciones</router-link>
        </p>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
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
