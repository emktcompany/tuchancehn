<template lang="html">
  <div class="flex items-center text-xs">
    <strong>ProJoven: &nbsp;</strong>
    <a v-tooltip.top-center="text" href @click.prevent class="rounded-xl flex items-center no-underline text-white px-2 py-1 text-2xs" :class="pillClass">
      {{ curso }}
    </a>
  </div>
</template>

<script>
import find from 'lodash/find';
export default {
  props: {
    curso: {
      required: true,
      type: String
    },
    estatus: {
      required: true,
      type: String
    },
    centro: {
      required: true,
      type: String
    }
  },
  computed: {
    pillClass() {
      if (this.estatus == 'Egresado') {
        return 'bg-teal';
      }

      if (this.estatus == 'En Proceso') {
        return 'bg-orange';
      }

      return 'bg-red';
    },
    text() {
      return this.estatus + ' en ' + this.centro;
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

<style lang="scss" scoped>
</style>
