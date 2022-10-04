<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Información personal</h2>
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-5/6 flex flex-wrap">
        <form-field class="w-full md:w-3/5 px-2" name="name" label="Nombre completo">
          <input type="text" name="name" v-validate="rules.name" class="form-field text-sm" v-model="data.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="email" label="Correo electrónico">
          <input type="email" name="email" v-validate="rules.email" class="form-field text-sm" v-model="data.email">
        </form-field>
        <div class="w-full md:w-3/5 flex flex-wrap">
          <form-field class="w-full sm:w-1/2 px-2" name="phone" label="Teléfono">
            <tel-input :country="country" class="form-field" name="phone" v-validate="rules.phone" v-model="data.candidate.phone" />
          </form-field>
          <form-field class="w-full sm:w-1/2 px-2" name="cell_phone" label="Celular">
            <tel-input :country="country" class="form-field" name="cell_phone" v-validate="rules.phone" v-model="data.candidate.cell_phone" />
          </form-field>
        </div>
        <form-field class="w-full md:w-2/5 px-2" name="birth" label="Fecha de Nacimiento">
          <date-input name="birth" v-validate="rules.birth" class="form-field" v-model="data.candidate.birth" />
        </form-field>
        <form-field class="w-full md:w-3/5 px-2" name="gender" label="Sexo">
          <radio-group v-model="data.candidate.gender" name="gender" v-validate="rules.gender" :options="$genders" />
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="driver_license" label="Permiso de conducir">
          <radio-group v-model="data.candidate.driver_license" name="driver_license" v-validate="rules.driver_license" :options="$yesNo" />
        </form-field>
      </div>
      <div class="md:w-1/6 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="data.avatar_crop" :default="data.avatar || null"/>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">¿Qué idiomas hablas?</h2>
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-5/6 flex flex-wrap">
        <div class="w-full md:w-3/5 flex flex-wrap">
          <form-field class="w-full sm:w-1/2 px-2" name="native_language" label="Lengua materna">
            <input type="text" name="native_language" v-validate="rules.languages" class="form-field text-sm" v-model="data.candidate.native_language">
          </form-field>
          <form-field class="w-full sm:w-1/2 px-2" name="others_language" label="Otros idiomas">
            <input type="text" name="others_language" v-validate="rules.languages" class="form-field text-sm" v-model="data.candidate.others_language">
          </form-field>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Cuéntanos de dónde eres</h2>
    <div class="flex flex-col-reverse md:flex-row -mx-2">
      <div class="md:w-5/6 flex flex-wrap">
        <form-field class="px-2 w-full md:w-1/3" name="country_id" label="País">
          <country-select name="country_id" v-model="data.country_id" v-validate="{required: true}" />
        </form-field>
        <form-field class="px-2 w-full md:w-1/3" name="state_id" label="Departamento">
          <state-select name="state_id" v-model="data.state_id" :country-id="data.country_id" />
        </form-field>
        <form-field class="px-2 w-full md:w-1/3" name="city_id" label="Municipio">
          <city-select name="city_id" v-model="data.city_id" :state-id="data.state_id" />
        </form-field>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Hoja de vida</h2>
    <div class="-mx-2">
      <form-field class="w-full px-2" name="summary" label="Resumen">
        <textarea name="summary" v-validate="{required: true}" class="form-field text-sm resize-none h-32 rounded-lg leading-loose" v-model="data.candidate.summary"></textarea>
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Formación escolar</h2>
    <div class="-mx-2">
      <div class="px-2">
        <school-experience v-model="data.candidate.school_experiences" />
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Experiencia Laboral</h2>
    <div class="-mx-2">
      <div class="px-2">
        <work-experience v-model="data.candidate.work_experience" />
      </div>
    </div>

    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Habilidades</h2>
    <form-field class="w-full" label="Agregar Habilidad">
      <v-select label="name" @input="addSkill" :options="skills" class="form-field">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <v-draggable v-model="data.candidate.skills" class="flex flex-wrap -mx-1">
      <div class="px-1" v-for="skill in data.candidate.skills">
        <div class="text-sm py-1 px-2 rounded-xl border-2 border-cyan text-cyan flex items-center">
          <confirm-button idle-class="text-cyan" class="mr-2" padding="p-0" icon-size="w-3 h-3" @confirmed="removeSkill(skill)" />
          {{skill.name}}
        </div>
      </div>
    </v-draggable>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Adjunta tu CV</h2>
    <form-field class="w-full" name="cv" label="Selecciona un archivo">
      <div class="flex -mx-2">
        <div class="px-2 mb-2">
          <a target="_blank" :href="data.candidate.cv.url" class="text-sm py-2 px-3 rounded-xl border-2 border-cyan text-cyan flex items-center uppercase no-underline" v-if="data.candidate.cv">
            <!-- <confirm-button idle-class="text-cyan" class="mr-2" padding="p-0" icon-size="w-3 h-3" @confirmed="removePdf" /> -->
            {{data.candidate.cv.original_filename}}
          </a>
        </div>
        <div class="px-2 mb-2">
          <file-input v-model="data.cv_attachment" />
        </div>
      </div>
    </form-field>
    <div class="text-center mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import find from 'lodash/find';
import findIndex from 'lodash/findIndex';
import SchoolExperience from './SchoolExperience.vue';
import WorkExperience from './WorkExperience.vue';
import {objectToFormData} from '@/lib/formData';
import FocusesOnError from '@/mixins/FocusesOnError';

export default {
  mixins: [FocusesOnError],
  components: {WorkExperience, SchoolExperience},
  data() {
    return {
      rules: {
        name: {required: true},
        email: {required: true, email: true},
        password: {},
        birth: {required: true, date_format: 'YYYY-MM-DD'},
        phone: {required: true, digits: 8},
        gender: {required: true},
        languages: {required: true},
        summary: {required: true},
        work_experience: {required: true},
        state_id: {},
        city_id: {},
        country_id: {required: true},
      },
      data: {
        candidate: {
          skills: [],
          school_experiences: [],
          work_experience: []
        },
        tag_ids: []
      },
      avatar_cropper: null,
      avatar: null,
      interests: [],
      skills: [],
      skill: null
    };
  },
  computed: {
    country() {
      var id = this.data.country_id || null;
      return find(this.$countries, {id}) || {states: []};
    },
    state() {
      var id = this.data.state_id || null;
      return find(this.country.states, {id}) || {cities: []};
    }
  },
  async created() {
    this.data   = this.$user;
    this.avatar = this.data.avatar && this.data.avatar.url;

    var response = await this.$http.get('interests');
    this.interests = response.data.data;

    var response = await this.$http.get('skills');
    this.skills = response.data.data;
  },
  methods: {
    async submit() {
      var valid = await this.$validator.validate();
      var form_data;

      if (valid) {
        form_data = objectToFormData(this.data);
        form_data.append('_method', 'put');

        try {
          var response = await this.$http.post('account/candidate', form_data);
          this.$auth.fetch();
          this.$notify({
            title: 'Éxito',
            text: 'Cuenta actualizada',
            type: 'success'
          });
        } catch (e) {
        }
      } else {
        this.focusOnError();
      }
    },
    addSkill(skill) {
      if (!find(this.data.candidate.skills, {id: skill.id})) {
        this.data.candidate.skills.push(skill);
      }
    },
    removeSkill({id}) {
      var index = findIndex(this.data.candidate.skills, {id});
      this.data.candidate.skills.splice(index, 1);
    },
    removePdf() {

    }
  }
}
</script>
