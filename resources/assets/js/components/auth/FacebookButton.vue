<template lang="html">
  <a href @click.prevent="login" class="bg-blue-light border-blue border rounded shadow block py-2 px-4 no-underline text-white hover:bg-blue hover:text-grey-lighter flex items-center">
    <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/brands/facebook.svg" />
    <div class="flex-1 pl-2 xs:text-xs"><slot>Continuar con Facebook</slot></div>
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
    login() {
      if (this.busy) {
        return;
      }

      this.busy = true;

      this.$FB.login((response) => {
        if (response.authResponse) {
          this.$http.post('/auth/facebook')
            .then((response) => {
              this.$emit('success', response.data);
            })
            .catch((error) => {
              this.$emit('fail', {
                response: error.response,
                authResponse: response.authResponse
              });
            })
            .finally(() => {
              this.busy = false;
            });
        } else {
          this.$notify({
            type: 'error',
            text: 'Por favor autoriza la aplicación'
          });

          this.busy = false;
        }
      }, {scope: 'email'});
    }
  }
}
</script>
