<template lang="html">
  <form @submit.prevent="submit">
    <facebook-button class="mb-3" @success="onSocialLogin" @fail="onFacebookProfile"/>
    <google-button class="mb-6" @success="onSocialLogin" @fail="onGoogleProfile"/>
    <hr class="border-t border-grey my-4">
    <form-field name="name" label="Nombre completo">
      <input type="text" name="name" v-validate="rules.name" class="form-field text-sm" v-model="data.name">
    </form-field>
    <form-field name="email" label="Correo electrónico">
      <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
    </form-field>
    <form-field name="password" label="Contraseña">
      <password-input v-validate="rules.password" name="password" v-model="data.password" />
    </form-field>
    <form-field name="phone" label="Teléfono">
      <input type="tel" name="phone" v-validate="rules.phone" class="form-field text-sm" v-model="data.candidate.phone">
    </form-field>
    <form-field name="birth" label="Fecha de Nacimiento">
      <date-input name="birth" v-validate="rules.birth" class="form-field" v-model="data.candidate.birth" />
    </form-field>
    <form-field name="gender" label="Sexo">
      <radio-group v-model="data.candidate.gender" name="gender" v-validate="rules.gender" :options="$genders" />
    </form-field>
    <div class="text-center mt-6">
      <button type="submit" class="btn bg-teal text-white">Crear cuenta</button>
    </div>
  </form>
</template>

<script>
import FocusesOnError from '@/mixins/FocusesOnError';
export default {
  mixins: [FocusesOnError],
  data() {
    return {
      rules: {
        name: {required: true},
        email: {required: true, email: true},
        password: {required: true},
        birth: {required: true, date_format: 'YYYY-MM-DD'},
        phone: {digits: 8},
        gender: {required: true},
      },
      data: {candidate: {}}
    };
  },
  watch: {
    $country(value) {
      if (value) {
        this.data.country_id = value.id;
      }
    }
  },
  methods: {
    onFacebookProfile(data) {
      this.onSocialProfile(data, 'facebook');
    },
    onGoogleProfile(data) {
      this.onSocialProfile(data, 'google');
    },
    onSocialProfile(data, network) {
      var profile = data.response.data.profile || null;

      if (profile) {
        this.data = Object.assign({candidate: {}, network}, profile);
      }
    },
    onSocialLogin(data) {
      this.$auth.token(null, data.access_token);
      this.$auth.user(data.user);
      this.$auth.watch.authenticated = true;
      this.$auth.watch.loaded = true;
      this.$router.push({name: 'index'});
      document.cookie='rememberMe=true';
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
    submit() {
      if (!this.data.country_id) {
        this.data.country_id = this.$country.id;
      }

      this.$validator.validate()
        .then((isValid) => {
          if (isValid) {
            this.$auth.register({
              url: 'register/candidate',
              data: this.data,
              autoLogin: true,
              redirect: '/'
            }).then((response) => {
              this.onLoggedIn(response.data.user)
            }, (error) => {
              var text = error.response.data.errors.email[0] || error.response.data.error;
              this.$notify({
                title: 'Error',
                text,
                type: 'error'
              });
            });
          } else {
            this.focusOnError();
          }
        });
    }
  }
}
</script>
