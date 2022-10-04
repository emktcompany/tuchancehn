<template lang="html">
  <nav class="flex flex-wrap items-center">
    <p class="text-lg font-dosis font-bold text-grey-dark xs:w-full mr-2">Buscar en:</p>
    <router-link  v-ripple :to="{ name: 'opportunities', query: {term: $route.query.term || '' } }" class="rounded-xl flex items-center no-underline px-2 py-1 text-xs mr-2" :class="current == 'opportunities' ? 'bg-red text-white' : 'bg-grey-lighter text-grey-dark'">Oportunidades</router-link>
    <router-link  v-ripple :to="{ name: 'bidders', query: {term: $route.query.term || '' } }" class="rounded-xl flex items-center no-underline px-2 py-1 text-xs mr-2" :class="current == 'bidders' ? 'bg-red text-white' : 'bg-grey-lighter text-grey-dark'">Oferentes</router-link>
    <router-link  v-ripple :to="{ name: 'category', params: {category: 'cursos-en-linea'}, query: {term: $route.query.term || '' } }" class="rounded-xl flex items-center no-underline px-2 py-1 text-xs" :class="current == 'category' ? 'bg-red text-white' : 'bg-grey-lighter text-grey-dark'">Cursos</router-link>
  </nav>
</template>

<script>
export default {
  computed: {
    current() {
      return this.$route.name;
    }
  }
}
</script>
