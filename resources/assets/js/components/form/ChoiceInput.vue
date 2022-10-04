<template lang="html">
  <v-select class="form-field" :options="options" :label="labelKey" v-model="selected" @input="onChange" :name="name" :placeholder="emptyText">
    <slot name="no-options">
      <div class="text-left text-sm px-2" slot="no-options">{{noOptions}}</div>
    </slot>
  </v-select>
</template>

<script>
import find from 'lodash/find';
import head from 'lodash/head';

export default {
  props: {
    name: {
      type: String,
      required: true
    },
    labelKey: {
      type: String,
      default: 'label'
    },
    valueKey: {
      type: String,
      default: 'value'
    },
    emptyText: {
      type: String,
      default: ''
    },
    options: {
      type: Array,
      default: () => []
    },
    value: {
      default: null
    },
    noOptions: {
      type: String,
      default: 'Sin resultados'
    }
  },
  data() {
    return {
      selected: null
    };
  },
  created() {
    this.inferSelected();
  },
  watch: {
    value() {
      this.inferSelected();
    },
    options() {
      this.inferSelected();
    }
  },
  methods: {
    onChange(value) {
      this.$emit('input', typeof value == 'object' && value !== null ? value[this.valueKey] : value);
    },
    inferSelected() {
      var firstOption = head(this.options);

      if (typeof firstOption == 'object' && firstOption !== null) {
        this.selected = find(this.options, (option) => {
          return option[this.valueKey] == this.value;
        });
      } else {
        this.selected = this.value;
      }
    }
  }
}
</script>
