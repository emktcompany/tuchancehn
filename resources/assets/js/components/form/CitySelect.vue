<template lang="html">
  <v-select class="form-field" label="name" :name="name" @input="onInput" :options="cities" v-model="selected" :placeholder="placeholder">
    <div class="text-left text-sm px-2" slot="no-options">{{noOptions}}</div>
  </v-select>
</template>

<script>
import find from 'lodash/find';

export default {
  props: {
    name: {
      type: String,
      default: 'city_id'
    },
    placeholder: {
      type: String,
      default: 'Municipio'
    },
    stateId: {
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
      cities: []
    };
  },
  created() {
    this.reload();
  },
  watch: {
    value() {
      this.inferSelected();
    },
    cities() {
      this.inferSelected();
    },
    stateId() {
      this.reload();
    }
  },
  computed: {
    noOptions() {
      return !this.stateId ? 'Selecciona un departamento' : 'No encontramos ese municipio';
    }
  },
  methods: {
    inferSelected() {
      if (this.value) {
        this.selected = find(this.cities, {id: this.value}) || null;
      } else {
        this.selected = null;
      }
    },
    async reload() {
      if (!this.stateId) {
        this.cities = [];
        return;
      }

      var response = await this.$http.get('locations/cities', {
        params: {
          state_id: this.stateId
        }
      });
      this.cities  = response.data.data;
      this.inferSelected();
    },
    onInput() {
      this.$emit('input', this.selected ? this.selected.id : null);
      this.$emit('change', this.selected);
    }
  }
}
</script>
