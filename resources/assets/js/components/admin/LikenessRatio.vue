<template lang="html">
  <div>
    <a v-tooltip="'Porcentaje de compatibilidad\nHaz click para conocer más'" href @click.prevent="open=true" class="rounded-xl flex items-center no-underline text-white p-1 text-xs" :class="pillClass">
      {{ pillText }}
    </a>
    <modal-dialog width="max-w-md" :shown="open" @modal-close="open=false">
      <h3 class="text-blue font-dosis text-3xl mb-6">Habilidades</h3>
      <div class="list-group border border-grey-light" v-if="opportunitySkills.length">
        <div class="list-group-item p-2 flex items-center" v-for="skill in opportunitySkills">
          <div class="flex-1">{{skill.name}}</div>
          <div class="flex-none">
            <div class="rounded-lg px-2 py-1 text-white" :class="{'bg-red': !hasSkill(skill), 'bg-teal': hasSkill(skill)}">
              <svg-icon class="fill-current w-3 h-3" src="~@svg/icons/solid/times.svg" v-if="!hasSkill(skill)"></svg-icon>
              <svg-icon class="fill-current w-3 h-3" src="~@svg/icons/solid/check.svg" v-if="hasSkill(skill)"></svg-icon>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="bg-orange text-white p-2 text-lg">
        Esta oportunidad no requiere ninguna habilidad en especial
      </div>
    </modal-dialog>
  </div>
</template>

<script>
import find from 'lodash/find';
export default {
  props: {
    likeness: {
      required: true,
      type: Number
    },
    candidateSkills: {
      required: true,
      type: Array
    },
    opportunitySkills: {
      required: true,
      type: Array
    }
  },
  computed: {
    pillClass() {
      if (this.likeness >= .75) {
        return 'bg-teal';
      }

      if (this.likeness >= .5) {
        return 'bg-orange';
      }

      return 'bg-red';
    },
    pillText() {
      return (this.likeness * 100).toFixed(2) + '%';
    }
  },
  data() {
    return {open: false}
  },
  methods: {
    hasSkill({id}) {
      return !!find(this.candidateSkills, {id});
    }
  }
}
</script>
