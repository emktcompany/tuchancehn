<template lang="html">
  <div>
    <div class="h-8 bg-purple"></div>
    <div class="max-w-xl mx-auto">
      <div class="flex flex-col-reverse md:flex-row-reverse">
        <div class="flex flex-col items-center flex-1 justify-center py-2">
          <h1 class="text-center text-grey-dark mb-4 font-dosis uppercase">
            {{ candidateUser.name }}
            <div class="h-1 bg-teal mt-4"></div>
          </h1>
        </div>
        <div class="flex flex-none w-full md:w-32 py-8 justify-center" v-if="candidateUser.avatar">
          <img :src="candidateUser.avatar.url" :alt="candidateUser.name" :width="candidateUser.avatar.width" :height="candidateUser.avatar.height" class="rounded-full w-32 h-32">
        </div>
      </div>
      <div class="h-4 bg-grey-light"></div>
      <div class="py-8 flex flex-col-reverse md:flex-row -mx-4 page-content">
        <div class="px-8 w-full md:w-1/3 text-grey-dark">
          <h2 class="font-dosis uppercase">Contacto</h2>
          <div class="h-px bg-grey-light"></div>
          <div class="flex items-center py-6">
            <div class="flex-none w-4 text-teal mr-2">
              <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/regular/envelope.svg" />
            </div>
            <div class="flex-1">
              <div class="truncate w-full">{{candidateUser.email}}</div>
            </div>
          </div>
          <div class="h-px bg-grey-light"></div>
          <template v-if="candidate.phone">
            <div class="flex items-center py-6">
              <div class="flex-none w-4 text-teal mr-2">
                <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/solid/phone.svg" />
              </div>
              <div class="flex-1">
                <div class="truncate w-full">{{candidate.phone}}</div>
              </div>
            </div>
            <div class="h-px bg-grey-light"></div>
          </template>
          <template v-if="candidate.cell_phone">
            <div class="flex items-center py-6">
              <div class="flex-none w-4 text-teal mr-2">
                <svg-icon class="fill-current w-4 h-4" src="~@svg/icons/solid/mobile-alt.svg" />
              </div>
              <div class="flex-1">
                <div class="truncate w-full">{{candidate.cell_phone}}</div>
              </div>
            </div>
            <div class="h-px bg-grey-light"></div>
          </template>
          <h2 class="font-dosis uppercase mt-12">Ubicación</h2>
          <div class="h-px bg-grey-light"></div>
          <div class="py-6">
            <strong>País:</strong> {{country.name}}
          </div>
          <div class="h-px bg-grey-light"></div>
          <template v-if="state">
            <div class="py-6">
              <strong>Departamento:</strong> {{state.name}}
            </div>
            <div class="h-px bg-grey-light"></div>
          </template>
          <template v-if="city">
            <div class="py-6">
              <strong>Municipio:</strong> {{city.name}}
            </div>
            <div class="h-px bg-grey-light"></div>
          </template>
        </div>
        <div class="px-8 w-full md:w-2/3 text-justify">
          <h2 class="font-dosis uppercase">Perfil</h2>
          <p>{{ candidate.summary }}</p>
          <template v-if="candidate.skills && candidate.skills.length">
            <h2 class="font-dosis uppercase">Habilidades</h2>
            <ul class="mb-2 mt-0">
              <li v-for="skill in candidate.skills">{{skill.name}}</li>
            </ul>
          </template>
          <template v-if="candidate.school_experiences && candidate.school_experiences.length">
            <h2 class="font-dosis uppercase">Formación Escolar</h2>
            <div class="h-px bg-grey-light"></div>
            <div class="">
              <template v-for="row in candidate.school_experiences">
                <div class="pt-6">
                  <p class="font-dosis text-teal text-xl font-bold uppercase">{{row.degree}}</p>
                  <div class="flex justify-between -mx-4 text-grey-dark">
                    <p class="px-4 uppercase">{{row.school}}</p>
                    <p class="px-4">
                      {{row.start_year}}/{{row.start_year}}
                      &nbsp;&mdash;&nbsp;
                      <template v-if="row.is_current === 'true' || row.is_current == '1' && row.is_current != '0' && row.is_current != 'false' && Number(row.is_current)">
                          Actualidad
                      </template>
                      <template v-if="row.leave_month && row.leave_year">
                        {{row.leave_month}}/{{row.leave_year}}
                      </template>
                    </p>
                  </div>
                </div>
                <div class="h-px bg-grey-light"></div>
              </template>
            </div>
          </template>
          <template v-if="candidate.work_experience && candidate.work_experience.length">
            <h2 class="font-dosis uppercase">Experiencia Laboral</h2>
            <div class="h-px bg-grey-light"></div>
            <div class="">
              <template v-for="row in candidate.work_experience">
                <div class="pt-6">
                  <p class="font-dosis text-teal text-xl font-bold uppercase">{{row.position}}</p>
                  <div class="flex justify-between -mx-4 text-grey-dark">
                    <p class="px-4 uppercase">{{row.company}}</p>
                    <p class="px-4">
                      {{row.start_year}}/{{row.start_year}}
                      &nbsp;&mdash;&nbsp;
                      <template v-if="row.is_current === 'true' || row.is_current == '1' && row.is_current != '0' && row.is_current != 'false' && Number(row.is_current)">
                          Actualidad
                      </template>
                      <template v-if="row.leave_month && row.leave_year">
                        {{row.leave_month}}/{{row.leave_year}}
                      </template>
                    </p>
                  </div>
                </div>
                <div class="h-px bg-grey-light"></div>
              </template>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    candidate: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    candidateUser() {
      return this.user || this.candidate.user;
    },
    country() {
      var country = this.candidate.country || this.candidateUser.country;
      return country;
    },
    state() {
      var state = this.candidate.state || this.candidateUser.state;
      return state;
    },
    city() {
      var city = this.candidate.city || this.candidateUser.city;
      return city;
    }
  }
}
</script>
