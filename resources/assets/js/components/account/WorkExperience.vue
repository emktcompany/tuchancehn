<template lang="html">
  <div>
    <work-experience-item :row="row" v-for="(row, i) in items" :key="`work-${i}`" @delete="remove(i)" @updated="update($event, i)" />
    <div class="text-center mt-6">
      <button type="button" @click.prevent="add" class="btn bg-purple text-white">Agregar otra experiencia laboral</button>
    </div>
  </div>
</template>

<script>
import WorkExperienceItem from './WorkExperienceItem.vue';

export default {
  components: {WorkExperienceItem},
  props: {
    value: {
      required: true
    }
  },
  data() {
    return {
      items: []
    };
  },
  created() {
    this.inferItems();

    if (!this.items.length) {
      this.add();
    }
  },
  watch: {
    value(value) {
      this.inferItems();
    }
  },
  methods: {
    inferItems() {
      this.items = this.value || [];
    },
    add() {
      this.items.push({});
    },
    remove(index) {
      this.items.splice(index, 1);
      this.$emit('input', this.items);
    },
    update($event, index) {
      this.items[index] = $event;
      this.$emit('input', this.items);
    }
  }
}
</script>
