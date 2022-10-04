<template lang="html">
  <article>
    <div class="md:w-3/4 mx-auto py-8">
      <h1 class="font-dosis text-purple font-bold flex-none mb-8">{{opportunity.name}}</h1>
      <div class="mb-8" v-if="opportunity.description">
        <div class="leading-loose" v-html="opportunity.description"></div>
      </div>
      <div class="mb-8" v-if="opportunity.characteristics">
        <p class="mb-2 text-xl font-bold font-dosis">Más detalles de la oportunidad</p>
        <div class="leading-loose" v-html="opportunity.characteristics"></div>
      </div>
      <div class="mb-8" v-if="opportunity.requirements">
        <p class="mb-2 text-xl font-bold font-dosis">Requisitos</p>
        <div class="leading-loose" v-html="opportunity.requirements"></div>
      </div>
      <template v-if="opportunity.has_enrolled">
        <hr class="border-t border-grey my-8">
        <p>Ya has enviado tu información a esta oportunidad.</p>
        <div class="flex flex-col sm:flex-row -mx-2 mt-6">
          <div class="px-2">
            <a @click.prevent class="btn text-white" :class="{'bg-green': opportunity.enrollment.is_accepted, 'bg-grey': !opportunity.enrollment.is_accepted}">{{
              opportunity.enrollment.is_accepted ? 'Aceptada' : 'Pendiente'
            }}</a>
          </div>
          <div class="px-2">
            <router-link :to="{name: 'my-opportunities'}" class="btn bg-cyan text-white">Ver mis oportunidades</router-link>
          </div>
        </div>
      </template>
      <div v-if="opportunity.allow_apply && !opportunity.has_enrolled">
        <a href @click.prevent="subscribe=true" class="btn bg-cyan text-white">Enviar mi información</a>
      </div>
      <div v-if="opportunity.link" :class="{'mt-6': opportunity.allow_apply || opportunity.has_enrolled}">
        <a target="_blank" :href="opportunity.link" class="btn bg-teal text-white">Ingresar al curso</a>
      </div>
    </div>
    <template v-if="opportunity.bidder">
      <div class="h-px bg-orange my-2"></div>
      <div class="md:w-3/4 mx-auto py-8">
        <bidder-preview :bidder="opportunity.bidder" />
      </div>
    </template>
    <modal-dialog width="max-w-md" :shown="subscribe" @modal-close="subscribe=false">
      <h3 class="text-orange font-dosis text-3xl mb-6">Enviar mi información</h3>
      <template v-if="!$auth.check()">
        <p class="mb-6">Ingresa con tus credenciales de candidato para continuar.</p>
        <login-form :redirect="false" />
      </template>
      <template v-else>
        <template v-if="$auth.check('candidate')">
          <p class="mb-6">Al enviar tu información, recibirás un correo con los pasos siguientes.</p>
          <div class="text-right">
            <a href @click.prevent="subscribe=false" class="btn bg-black text-white inline-block cursor-pointer">Cancelar</a>
            <a href @click.prevent="enroll" class="btn bg-teal text-white inline-block cursor-pointer">Enviar información</a>
          </div>
        </template>
        <template v-else>
          <p class="mb-6">Esta opción solo está disponible para candidatos.</p>
          <div class="text-right">
            <a href @click.prevent="subscribe=false" class="btn bg-black text-white inline-block cursor-pointer">Cancelar</a>
          </div>
        </template>
      </template>
    </modal-dialog>
  </article>
</template>

<script>
export default {
  props: {
    opportunity: {
      type: Object,
      required: true
    }
  },
  data() {
    return { subscribe: false };
  },
  methods: {
    async enroll() {
      this.subscribe = false;
      try {
        const response = await this.$http
          .post(`opportunities/${this.opportunity.slug}`);

        this.$emit('enrolled', response.data.data);

        this.$notify({
          title: 'Éxito',
          text: 'Información enviada con éxito',
          type: 'success'
        });
      } catch (e) {
        this.$notify({
          title: 'Error',
          text: 'Ocurrió un error, por favor intenta de nuevo',
          type: 'error'
        });
      }
    }
  }
}
</script>
