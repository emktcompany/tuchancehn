<template lang="html">
  <v-select class="form-field" label="name" :name="name" @input="onInput" :options="countries" v-model="selected" :placeholder="label">
    <div class="text-left text-sm px-2" slot="no-options">Sin resultados</div>
  </v-select>
</template>

<script>
import find from 'lodash/find';

export default {
  props: {
    name: {
      type: String,
      default: 'country_id'
    },
    label: {
      type: String,
      default: 'País'
    },
    value: {
      required: false
    }
  },
  data() {
    return {
      selected: null,
      countries: []
    };
  },
  async created() {
    this.countries = await this.$root.getAllCountries();
    this.inferSelected();
  },
  watch: {
    value() {
      this.inferSelected();
    }
  },
  methods: {
    inferSelected() {
      if (this.value) {
        this.selected = find(this.countries, {id: this.value}) || null;
      } else {
        this.selected = null;
      }
    },
    async reload() {
      var response   = await this.$http.get('locations/countries');
      this.countries = response.data.data;
      this.inferSelected();
    },
    onInput() {
      this.$emit('input', this.selected ? this.selected.id : null);
      this.$emit('change', this.selected);
    }
  }
}
</script>
