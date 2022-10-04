<template lang="html">
  <v-select class="form-field" label="name" :name="name" @input="onInput" :options="states" v-model="selected" :placeholder="placeholder">
    <div class="text-left text-sm px-2" slot="no-options">{{noOptions}}</div>
  </v-select>
</template>

<script>
import find from 'lodash/find';

export default {
  props: {
    name: {
      type: String,
      default: 'state_id'
    },
    placeholder: {
      type: String,
      default: 'Departamento'
    },
    countryId: {
      type: [Number, null],
      default: null
    },
    value: {
      required: false
    }
  },
  data() {
    return {
      selected: null,
      states: []
    };
  },
  created() {
    this.reload();
  },
  watch: {
    value() {
      this.inferSelected();
    },
    states() {
      this.inferSelected();
    },
    countryId() {
      this.reload();
    }
  },
  computed: {
    noOptions() {
      return !this.countryId ? 'Selecciona un país' : 'No encontramos ese departamento';
    }
  },
  methods: {
    inferSelected() {
      if (this.value) {
        this.selected = find(this.states, {id: this.value}) || null;
      } else {
        this.selected = null;
      }
    },
    async reload() {
      if (!this.countryId) {
        this.states = [];
        return;
      }

      var response = await this.$http.get('locations/states', {
        params: {
          country_id: this.countryId
        }
      });
      this.states  = response.data.data;
      this.inferSelected();
    },
    onInput() {
      this.$emit('input', this.selected ? this.selected.id : null);
      this.$emit('change', this.selected);
    }
  }
}
</script>
