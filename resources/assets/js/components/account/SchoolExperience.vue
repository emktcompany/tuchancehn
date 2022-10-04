<template lang="html">
  <div>
    <school-experience-item :row="row" v-for="(row, i) in items" :key="`work-${i}`" @delete="remove(i)" @updated="update($event, i)" />
    <div class="text-center mt-6">
      <button type="button" @click.prevent="add" class="btn bg-purple text-white">Agregar otra formación escolar</button>
    </div>
  </div>
</template>

<script>
import SchoolExperienceItem from './SchoolExperienceItem.vue';

export default {
  components: {SchoolExperienceItem},
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
    this.items = this.value || [];

    while (this.items.length < 2) {
      this.add();
    }
  },
  watch: {
    value(value) {
      if (value != this.items) {
        this.items = value || [];
      }
    }
  },
  methods: {
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
