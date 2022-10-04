<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-8 lg:p-12 max-w-xl mx-auto mb-12">
    <div class="flex flex-col-reverse lg:flex-row -mx-2">
      <div class="lg:w-5/6 flex flex-wrap">
        <form-field class="w-full md:w-3/5 px-2" name="name" label="Nombre completo">
          <input type="text" name="name" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.user.name">
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="email" label="Correo electrónico">
          <input type="email" name="email" v-validate="{required: true, email: true}" class="form-field text-sm" v-model="row.data.user.email">
        </form-field>
        <div class="w-full md:w-3/5 flex flex-wrap">
          <form-field class="w-full sm:w-1/2 md:w-full lg:w-1/2 px-2" name="phone" label="Teléfono">
            <tel-input :country="country" class="form-field" name="phone" v-validate="{numeric: true}" v-model="row.data.phone" />
          </form-field>
          <form-field class="w-full sm:w-1/2 md:w-full lg:w-1/2 px-2" name="cell_phone" label="Celular">
            <tel-input :country="country" class="form-field" name="cell_phone" v-validate="{numeric: true}" v-model="row.data.cell_phone" />
          </form-field>
        </div>
        <form-field class="w-full md:w-2/5 px-2" name="birth" label="Fecha de Nacimiento">
          <date-input name="birth" v-validate="{required: true, date_format: 'YYYY-MM-DD'}" class="form-field" v-model="row.data.birth" />
        </form-field>
        <form-field class="w-full md:w-3/5 px-2" name="gender" label="Sexo">
          <radio-group v-model="row.data.gender" name="gender" v-validate="{required: true}" :options="$genders" />
        </form-field>
        <form-field class="w-full md:w-2/5 px-2" name="driver_license" label="Permiso de conducir">
          <radio-group v-model="row.data.driver_license" name="driver_license" :options="$yesNo" />
        </form-field>
      </div>
      <div class="lg:w-1/6 flex justify-center px-2">
        <div class="w-32 text-center">
          <image-cropper v-model="row.data.avatar_crop" :default="row.data.user.avatar || null"/>
        </div>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Idiomas</h2>
    <div class="flex md:flex-row -mx-2">
      <form-field class="w-full sm:w-3/5 px-2" name="native_language" label="Lengua materna">
        <input type="text" name="native_language" class="form-field text-sm" v-model="row.data.native_language">
      </form-field>
      <form-field class="w-full sm:w-2/5 px-2" name="others_language" label="Otros idiomas">
        <input type="text" name="others_language" class="form-field text-sm" v-model="row.data.others_language">
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Ubicación</h2>
    <div class="flex flex-wrap -mx-2">
      <form-field class="px-2 w-full lg:w-1/3" name="country_id" label="País">
        <country-select v-validate="{required: true}" @change="onCountryChange" name="country_id" v-model="row.data.user.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="state_id" label="Departamento">
        <state-select name="state_id" v-model="row.data.user.state_id" :country-id="row.data.user.country_id" />
      </form-field>
      <form-field class="px-2 w-full lg:w-1/3" name="city_id" label="Municipio">
        <city-select name="city_id" v-model="row.data.user.city_id" :state-id="row.data.user.state_id" />
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Hoja de vida</h2>
    <div class="-mx-2">
      <form-field class="w-full px-2" name="summary" label="Resumen">
        <textarea name="summary" v-validate="{required: true}" class="form-field text-sm resize-none h-32 rounded-lg leading-loose" v-model="row.data.summary"></textarea>
      </form-field>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Formación escolar</h2>
    <div class="-mx-2">
      <div class="px-2">
        <school-experience v-model="row.data.school_experiences" />
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Experiencia Laboral</h2>
    <div class="-mx-2">
      <div class="px-2">
        <work-experience v-model="row.data.work_experience" />
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Habilidades</h2>
    <form-field class="w-full" label="Agregar Habilidad">
      <v-select label="name" @input="addSkill" :options="skills" class="form-field">
        <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
      </v-select>
    </form-field>
    <v-draggable v-model="row.data.skills" class="flex flex-wrap -mx-1">
      <div class="px-1" v-for="skill in row.data.skills">
        <div class="text-sm py-1 px-2 rounded-xl border-2 border-cyan text-cyan flex items-center">
          <confirm-button idle-class="text-cyan" class="mr-2" padding="p-0" icon-size="w-3 h-3" @confirmed="removeSkill(skill)" />
          {{skill.name}}
        </div>
      </div>
    </v-draggable>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Configuración de la cuenta</h2>
    <div class="flex flex-wrap -mx-2">
      <form-field class="w-full md:w-2/3 px-2" name="password" label="Contraseña">
        <password-input v-validate="{required: !$route.params.id, min: 8}" name="password" v-model="row.data.user.password" />
      </form-field>
      <form-field class="w-full md:w-1/3 px-2" name="subscription" label="Notificaciones por correo">
        <radio-group v-model="row.data.subscription" name="subscription" v-validate="{required: true}" :options="$yesNo" />
      </form-field>
      <form-field class="w-full md:w-2/3 px-2" :error="null" label="Intereses">
        <label class="whitespace-no-wrap inline-block mb-2 radio text-sm mr-3" v-for="category in interests">
          <input type="checkbox" :id="`interest-${category.id}`" :value="category.id" name="tag_ids[]" v-model="row.data.user.tag_ids">
          {{category.name}}
        </label>
      </form-field>
      <form-field class="w-full md:w-1/3 px-2" name="is_active" label="Perfil Activo">
        <radio-group v-model="row.data.user.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
      </form-field>
      <h2 class="font-dosis font-bold text-purple mb-4 mt-12">CV</h2>
      <form-field class="w-full" name="cv" label="Selecciona un archivo">
        <div class="flex -mx-2">
          <div class="px-2 mb-2">
            <a target="_blank" :href="row.data.cv.url" class="text-sm py-2 px-3 rounded-xl border-2 border-cyan text-cyan flex items-center uppercase no-underline" v-if="row.data.cv">
              <!-- <confirm-button idle-class="text-cyan" class="mr-2" padding="p-0" icon-size="w-3 h-3" @confirmed="removePdf" /> -->
              {{row.data.cv.original_filename}}
            </a>
          </div>
          <div class="px-2 mb-2">
            <file-input v-model="row.data.cv_attachment" />
          </div>
        </div>
      </form-field>
    </div>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
    </div>
  </form>
</template>

<script>
import FormPage from '@/components/admin/FormPage.vue';
import SchoolExperience from '@/components/account/SchoolExperience.vue';
import WorkExperience from '@/components/account/WorkExperience.vue';

var row = {
  user: {
    avatar: null,
    name: '',
    password: '',
    email: '',
    tag_ids: []
  },
  web: null,
  phone: null,
  cell_phone: null,
  summary: null,
  services: null,
  description: null,
  skills: [],
  skill_ids: [],
  work_experience: [],
  school_experiences: []
};

export default {
  components: {WorkExperience, SchoolExperience},
  extends: FormPage,
  data() {
    return {
      country: null,
      row: {data: Object.assign({}, row)},
      skills: [],
      interests: [],
    };
  },
  async created() {
    var response = await this.$http.get('interests');
    this.interests = response.data.data;

    response = await this.$http.get('skills');
    this.skills = response.data.data;
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.candidates.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: Object.assign({}, row)
      };
    },
    onCountryChange(country) {
      this.country = country;
    },
    addSkill(skill) {
      if (!find(this.row.data.skills, {id: skill.id})) {
        this.row.data.skills.push(skill);
      }
    },
    removeSkill({id}) {
      var index = findIndex(this.row.data.skills, {id});
      this.row.data.skills.splice(index, 1);
    }
  }
}
</script>
