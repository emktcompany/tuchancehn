<template lang="html">
  <form @submit.prevent="submit">
    <facebook-button class="mb-3" @fail="socialLoginFail('Facebook')" @success="onSocialLogin"/>
    <google-button class="mb-6" @fail="socialLoginFail('Google')" @success="onSocialLogin"/>
    <hr class="border-t border-grey my-4">
    <form-field name="email" label="Correo electrónico">
      <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
    </form-field>
    <form-field name="password" label="Contraseña">
      <password-input v-validate="rules.password" name="password" v-model="data.password" />
    </form-field>
    <div class="text-center mt-6">
      <button type="submit" class="btn bg-teal text-white">Iniciar sesión</button>
      <p class="mt-6 text-sm">
        ¿Aún no posees una cuenta?
        <router-link :to="{name: 'register.default'}" class="text-grey-dark">Registrate</router-link>
      </p>
      <p class="mt-3 text-sm">
        <router-link :to="{name: 'remind'}" class="text-grey-dark">¿Olvidaste tu contraseña?</router-link>
      </p>
    </div>
  </form>
</template>

<script>
import FocusesOnError from '@/mixins/FocusesOnError';
export default {
  mixins: [FocusesOnError],
  props: {
    redirect: {
      type: [Object, Boolean],
      default: () => {
        return {name: 'index'};
      }
    }
  },
  data() {
    return {
      rules: {
        email: {required: true, email: true},
        password: {required: true},
      },
      data: {}
    };
  },
  methods: {
    async submit() {
      const valid = await this.$validator.validate();

      if (!valid) {
        this.focusOnError();
        return;
      }

      this.login();
    },
    async login() {
      try {
        const response = await this.$auth.login({
          data: this.data,
          redirect: this.redirect
        });

        this.$emit('logged-in', response);

        this.onLoggedIn(response.data.user);
      } catch (e) {
        this.$emit('error', e);
        this.onError();
        throw e;
      }
    },
    socialLoginFail(network) {
      this.$notify({
        type: 'error',
        text: 'No existe un usuario asociado a esta cuenta de ' + network
      });
    },
    onSocialLogin(data) {
      this.$auth.token(null, data.access_token);
      this.$auth.user(data.user);
      this.$auth.watch.authenticated = true;
      this.$auth.watch.loaded = true;
      document.cookie='rememberMe=true';

      if (this.redirect) {
        this.$router.push(this.redirect);
      }

      this.onLoggedIn(data.user);
    },
    onLoggedIn(user) {
      var keyword = 'Bienvenid@';

      if (user.candidate && user.candidate.gender !== null) {
        keyword = user.candidate.gender ? 'Bienvenido' : 'Bienvenida';
      }

      this.$notify({
        title: 'Éxito',
        text: `${keyword} ${user.name}`,
        type: 'success'
      });
    },
    onError(error) {
      this.$notify({
        title: 'Error',
        text: `Credenciales inválidas`,
        type: 'error'
      });
    }
  }
}
</script>
