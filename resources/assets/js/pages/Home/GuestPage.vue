<template lang="html">
  <div class="overflow-hidden">
    <home-carousel :banners="banners"/>
    <section class="bg-white py-12">
      <h2 class="text-center text-4xl font-dosis font-bold text-red mb-4 px-2">¿Qué puedo encontrar?</h2>
      <p class="text-center leading-loose text-grey-dark px-2 mb-8">Aprovecha todas las oportunidades que hay para tí.</p>
      <div class="mx-auto max-w-xl relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <nav class="flex justify-center lg:justify-between flex-wrap -mx-4">
            <router-link  v-ripple :to="{name: 'category', params: {category: category.slug}}" class="block m-3 lg:m-4 w-40 h-40 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-full flex flex-col items-center justify-center text-white no-underline text-sm md:text-xs lg:text-sm p-4 text-center" :class="`bg-${category.color}`" v-for="category in $categories" :key="`category-${category.id}`">
              <img :src="category.image.url" class="block mx-auto mb-2" />
              {{ category.name }}
            </router-link>
          </nav>
        </div>
      </div>
    </section>
    <section class="bg-white py-12">
      <div class="container">
        <div class="flex flex-col md:flex-row -mx-4">
          <div class="md:w-1/2 px-4">
            <h2 class="text-2xl font-dosis text-red mb-8">¿Qué es <strong>TuChance</strong>?</h2>
            <p class="leading-loose text-grey-dark">Es una ventana virtual a la oferta de oportunidades de formación, becas, empleos, entrenamiento y capacitación que te permitirá acceder al mercado laboral, desarrollar habilidades técnico-profesionales o bien conocer la oferta de servicios que diferentes organizaciones ponen a tu disposición.</p>
            <p class="font-bold leading-loose text-grey-dark">
              <router-link class="text-purple no-underline" :to="{ name: 'bidders' }">Instituciones que trabajan con nosotros</router-link>
            </p>
          </div>
          <div class="md:w-1/2 px-4 md:pt-0 pt-8">
            <img src="~@img/about-tuchance.jpg" alt="" width="607" height="300" class="block mx-auto">
          </div>
        </div>
      </div>
    </section>
    <section class="bg-white py-12">
      <div class="container">
        <div class="flex flex-col md:flex-row-reverse -mx-4">
          <div class="md:w-1/2 px-4">
            <h2 class="text-2xl font-dosis text-red mb-8">¡Conoce el programa <strong>Capacítate para el empleo</strong>!</h2>
            <p class="leading-loose text-grey-dark">Es una iniciativa que tiene la misión de ofrecer capacitación gratuita en línea de oficios y ocupaciones técnico operativas para contribuir al desarrollo de competencias productivas.<br>
              Aprende habilidades en oficios para obtener un mejor empleo o comenzar tu propio negocio. Los cursos son gratuitos.</p>
            <p class="font-bold leading-loose text-grey-dark">
              <a class="text-purple no-underline" href="https://capacitateparaelempleo.org" target="_blank">capacitateparaelempleo.org</a>
            </p>
          </div>
          <div class="md:w-1/2 px-4 md:pt-0 pt-8">
            <img src="~@img/about-capacitate.jpg" alt="" width="360" height="300" class="block mx-auto">
          </div>
        </div>
      </div>
    </section>
    <section class="bg-cyan py-12 my-8 text-white">
      <div class="max-w-lg mx-auto px-4 justify-between flex flex-col sm:flex-row">
        <div class="px-4 flex items-center flex-none">
          <div class="font-dosis font-bold text-6xl pr-3">
            <animated-number :number="stats.visits"></animated-number>
          </div>
          <div>Total de<br>
            visitas</div>
        </div>
        <div class="px-4 flex items-center flex-none">
          <div class="font-dosis font-bold text-6xl pr-3">
            <animated-number :number="stats.courses"></animated-number>
          </div>
          <div>Cursos certificados<br>
            con INSAFORP</div>
        </div>
        <div class="px-4 flex items-center flex-none">
          <div class="font-dosis font-bold text-6xl pr-3">
            <animated-number :number="stats.users"></animated-number>
          </div>
          <div>Usuarios<br>
            registrados</div>
        </div>
      </div>
    </section>
    <section class="bg-white py-12">
      <div class="container relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <h2 class="text-center text-4xl font-dosis font-bold text-red mb-8 px-2">Oportunidades a las que tú puedes aplicar</h2>
          <div class="flex flex-wrap py-8 -mx-4" v-if="hasResults">
            <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in opportunities" :key="`opportunity-${opportunity.id}`">
              <opportunity-preview :opportunity="opportunity"></opportunity-preview>
            </div>
          </div>
          <div v-else>
            <alert-box message="No se han publicado oportunidades" />
          </div>
        </div>
      </div>
    </section>
    <section class="bg-white py-12" v-for="bidder in featured.data">
      <div class="container relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <h2 class="text-center text-4xl font-dosis font-bold text-red mb-8 px-2">{{bidder.name}}</h2>
          <div class="flex flex-wrap py-8 -mx-4">
            <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in bidder.opportunities" :key="`opportunity-${opportunity.id}`">
              <opportunity-preview :opportunity="opportunity"></opportunity-preview>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="bg-white py-12">
      <div class="container xs:px-12">
        <h2 class="text-center text-4xl font-dosis font-bold text-red mb-8">Testimonios</h2>
        <carousel :per-page="1" :pagination-enabled="false" :navigation-enabled="true" v-if="testimonials.data.length">
          <slide v-for="testimonial in testimonials.data" :key="`testimonial-${testimonial.id}`" class="flex items-center">
            <div class="container min-h-32">
              <p class="text-center text-grey-dark">{{testimonial.body}}</p>
              <p class="text-center text-purple font-bold mt-8">{{testimonial.name}}</p>
            </div>
          </slide>
        </carousel>
      </div>
    </section>
  </div>
</template>

<script>

import filter from 'lodash/filter';

export default {
  props: {
    testimonials: {
      type: Object,
      default: () => {}
    },
    featured: {
      type: Object,
      default: () => {}
    },
    stats: {
      type: Object,
      default: () => {
        return {visits: 0, courses: 0, users: 0};
      }
    }
  },
  data() {
    return {
      opportunities: [],
      banners: []
    }
  },
  async created() {
    var response = await this.$http.get('/banners', {
      params: {type: 1}
    });

    this.banners = response.data.data;

    var query = {};
    query.per_page = 4;
    query.interests = 1;
    var response = await this.$http.get('/opportunities', {params: query});
    this.opportunities = response.data.data;
  },
  computed: {
    hasResults() {
      return this.opportunities.length > 0;
    },
    hasFeatured() {
      return (this.featured.data || []).length > 0;
    }
  }
}
</script>
