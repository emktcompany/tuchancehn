<template lang="html">
  <section class="relative pt-24 md:pt-32">
    <div class="container">
      <div class="flex flex-col md:flex-row justify-between md:pt-12 pb-12">
        <div class="w-full md:w-1/2 py-8 text-center md:text-left text-shadow-dense md:text-shadow-none">
          <breadcrumbs-list text-color="text-white" />
          <div class="font-dosis text-5xl lg:text-6xl text-white pt-4 md:pt-12">
            <div>Es tu momento.</div>
            <div>Es tu decisión.</div>
            <div>¡Comienza hoy!</div>
          </div>
        </div>
        <div class="w-full md:w-1/2 flex justify-center">
          <div class="w-full max-w-xs p-6 sm:p-12 bg-white">
            <div class="font-dosis font-bold text-3xl text-purple mb-6">Recuperar Contraseña</div>
            <form @submit.prevent="submit">
              <form-field name="email" label="Correo electrónico">
                <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
              </form-field>
              <div class="text-center mt-6">
                <button type="submit" class="btn bg-teal text-white">Enviar</button>
                <p class="mt-6 text-sm">
                  ¿Aún no posees una cuenta?
                  <router-link :to="{name: 'register.default'}" class="text-grey-dark">Registrate</router-link>
                </p>
                <p class="mt-3 text-sm text-center flex-none">
                  ¿Ya posees una cuenta?
                  <router-link :to="{name: 'login'}" class="text-grey-dark">Inicia Sesión</router-link>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import FocusesOnError from '@/mixins/FocusesOnError';
export default {
  mixins: [FocusesOnError],
  data() {
    return {
      rules: {
        email: {required: true, email: true}
      },
      data: {}
    };
  },
  methods: {
    async submit() {
      const valid = await this.$validator.validate();

      if (!valid) {
        this.focusOnError();
        return
      }

      this.send();
    },
    async send() {
      try {
        const response = await this.$http.post('password/remind', this.data);
        this.onSuccess(response.data.user);
      } catch (e) {
        this.onError();
        throw e;
      }
    },
    onSuccess(user) {
      this.$notify({
        title: 'Éxito',
        text: `En un momento recibirás instrucciones para recuperar tu cuenta`,
        type: 'success'
      });
    },
    onError(error) {
      this.$notify({
        title: 'Error',
        text: `Ocurrió un error, por favor intenta más tarde`,
        type: 'error'
      });
    }
  }
}
</script>
