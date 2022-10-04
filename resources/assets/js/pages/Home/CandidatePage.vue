<template lang="html">
  <div class="overflow-hidden">
    <home-carousel :banners="banners"/>
    <section class="bg-white py-12">
      <div class="container relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <h2 class="text-center text-4xl font-dosis font-bold text-red mb-4 px-2">¡Descubre oportunidades especiales para ti!</h2>
          <p class="text-center leading-loose text-grey-dark px-2 mb-8">Hemos encontrado estas oportunidades que se adaptan a tus intereses. ¡Léelas ahora!</p>
          <div class="flex flex-wrap -mx-4" v-if="hasResults">
            <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in opportunities">
              <opportunity-preview :opportunity="opportunity"></opportunity-preview>
            </div>
          </div>
          <p class="text-center mt-6">
            <router-link class="btn bg-red text-white no-underline font-bold font-dosis" :to="{ name: 'opportunities' }">Explora todas las oportunidades</router-link>
          </p>
        </div>
      </div>
    </section>
    <section class="bg-white py-12" v-for="bidder in featured.data">
      <div class="container relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <h2 class="text-center text-4xl font-dosis font-bold text-red mb-8 px-2"><router-link class="text-red no-underline block hover:underline" :to="{ name: 'bidder', params: {slug: bidder.slug} }">{{bidder.name}}</router-link></h2>
          <div class="flex flex-wrap py-8 -mx-4">
            <div class="px-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 pb-8" v-for="opportunity in bidder.opportunities" :key="`opportunity-${opportunity.id}`">
              <opportunity-preview :opportunity="opportunity"></opportunity-preview>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="bg-white py-12">
      <h2 class="text-center text-4xl font-dosis font-bold text-red mb-4 px-2">Encuentra más oportunidades</h2>
      <div class="mx-auto max-w-xl relative">
        <div class="dot absolute bg-cyan" style="top:16px;left:0;"></div>
        <div class="dot absolute bg-teal" style="bottom:16px;right:-20px;width:75px;height:75px"></div>
        <div class="relative">
          <nav class="flex justify-center lg:justify-between flex-wrap -mx-4">
            <category-badge :key="`home-cat-${category.id}`" v-for="category in $categories" :id="category.id" />
          </nav>
        </div>
      </div>
    </section>
    <section class="bg-purple py-12">
      <div class="container flex flex-col sm:flex-row items-center">
        <p class="font-dosis text-2xl flex-1 leading-none text-white">¿No sabes por dónde comenzar? ¡Nosotros te guíamos!</p>
        <p class="flex-1 sm:flex-none leading-none text-white"><router-link :to="{name: 'about'}" class="btn bg-white text-purple uppercase">Comunícate con nosotros</router-link></p>
      </div>
    </section>
    <section class="bg-white py-12">
      <div class="container">
        <h2 class="text-center text-4xl font-dosis font-bold text-red mb-4 px-2">Preguntas Frecuentes</h2>
        <v-collapse-group>
          <ul class="list-reset">
            <li class="bg-grey-lighter block mb-3 px-4" v-for="faq in faqs">
              <v-collapse-wrapper>
                <div v-collapse-toggle class="font-dosis text-2xl cursor-pointer text-grey-dark flex items-center py-3">
                  <span class="flex-1">{{faq.question}}</span>
                  <span class="bg-grey-light flex-none rounded-full w-6 h-6 flex items-center justify-center leading-none text-sm"><span>+</span></span>
                </div>
                <div v-collapse-content>
                  <div class="py-3 text-grey-dark">{{faq.answer}}</div>
                </div>
              </v-collapse-wrapper>
            </li>
          </ul>
        </v-collapse-group>
      </div>
    </section>
  </div>
</template>

<script>
import filter from 'lodash/filter';

export default {
  props: {
    featured: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      opportunities: [],
      banners: [],
      faqs: []
    }
  },
  async created() {
    var response = await this.$http.get('/banners', {
      params: {type: 2}
    });
    this.banners = response.data.data;

    var response = await this.$http.get('/faqs', {
      params: {type: 1}
    });
    this.faqs = response.data.data;

    var query = {};
    query.per_page = 4;
    query.interests = 1;
    var response = await this.$http.get('/opportunities', {params: query});
    this.opportunities = response.data.data;
  },
  computed: {
    hasResults() {
      return this.opportunities.length > 0;
    }
  }
}
</script>
