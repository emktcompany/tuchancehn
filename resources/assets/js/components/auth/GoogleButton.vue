<template lang="html">
  <a href @click.prevent="login" class="bg-white border-grey-light border rounded shadow block py-2 px-4 no-underline text-grey-dark hover:bg-grey-lighter hover:text-grey-darker flex items-center">
    <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/brands/google.svg" />
    <span class="flex-1 pl-2 xs:text-xs"><slot>Continuar con Google</slot></span>
  </a>
</template>

<script>
export default {
  data() {
    return {
      busy: false,
      succeded: false
    };
  },
  methods: {
    async login() {
      if (this.busy) {
        return;
      }

      this.busy = true;

      this.$auth2.grantOfflineAccess()
        .then((authResponse) => {
          if (authResponse.code) {
            this.$http.post('/auth/google', {code: authResponse.code})
              .then((response) => {
                this.$emit('success', response.data);
              })
              .catch((error) => {
                this.$emit('fail', {
                  response: error.response,
                  authResponse
                });
              })
              .finally(() => {
                this.busy = false;
              });
          } else {
            this.$notify({
              type: 'error',
              text: 'Ocurrió un error, por favor intenta de nuevo'
            });

            this.busy = false;
          }
        })
        .catch((error) => {
          this.$notify({
            type: 'error',
            text: 'Por favor autoriza la aplicación'
          });
          this.busy = false;
        });
    }
  }
}
</script>
