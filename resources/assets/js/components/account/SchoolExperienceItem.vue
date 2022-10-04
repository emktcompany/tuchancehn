<template lang="html">
  <div class="flex py-4 border-b border-grey md:border-b-0">
    <div class="flex-1">
      <div class="flex -mx-2 flex-col md:flex-row flex-wrap">
        <form-field class="w-full md:w-1/2 lg:w-1/4 px-2" name="school" label="Institución">
          <input type="text" name="school" v-validate="rules.school" class="form-field text-sm" v-model="data.school" @input="onInput">
        </form-field>
        <form-field class="w-full md:w-1/2 lg:w-1/4 px-2" name="degree" label="Título Obtenido">
          <input type="text" name="degree" v-validate="rules.degree" class="form-field text-sm" v-model="data.degree" @input="onInput">
        </form-field>
        <form-field class="w-full md:w-1/2 lg:w-1/4 px-2" :error="null" label="Fecha de inicio">
          <div class="flex -mx-2">
            <div class="flex-none px-2">
              <select name="start_month" v-model="data.start_month" class="form-field" v-validate="rules.start_month">
                <option :value="i" v-for="i in (1, 12)">{{i}}</option>
              </select>
            </div>
            <div class="flex-none px-2">
              <select name="start_year" v-model="data.start_year" class="form-field w-24" v-validate="rules.start_year">
                <option :value="i" v-for="i in years">{{i}}</option>
              </select>
            </div>
          </div>
        </form-field>
        <form-field v-if="!data.is_current" class="w-full md:w-1/2 lg:w-1/4 px-2" :error="null" label="Fecha de finalización">
          <div class="flex -mx-2">
            <div class="flex-none px-2">
              <select name="leave_month" v-model="data.leave_month" class="form-field" v-validate="rules.leave_month">
                <option :value="i" v-for="i in (1, 12)">{{i}}</option>
              </select>
            </div>
            <div class="flex-none px-2">
              <select name="leave_year" v-model="data.leave_year" class="form-field" v-validate="rules.leave_year">
                <option :value="i" v-for="i in years">{{i}}</option>
              </select>
            </div>
          </div>
        </form-field>
      </div>
    </div>
    <div class="flex-none">
      <form-field :error="null" label="Actual">
        <div class="text-center py-2">
          <input type="checkbox" name="is_current" v-model="data.is_current" @input="onInput">
        </div>
      </form-field>
    </div>
    <div class="flex-none pt-8 px-2">
      <confirm-button @confirmed="$emit('delete')"></confirm-button>
    </div>
  </div>
</template>

<script>
import range from 'lodash/range';

export default {
  props: {
    row: {
      required: true
    }
  },
  data() {
    return {
      data: {},
      rules: {
        school: {required: true},
        degree: {required: true},
        start_month: {required: true},
        start_year: {required: true},
        leave_month: {required: true},
        leave_year: {required: true},
      },
      // currentYear: this.$dayjs().year(),
      years: range(2000, this.$dayjs().year() + 1).reverse()
    };
  },
  created() {
    this.data = this.row;
  },
  watch: {
    row(value) {
      this.data = value || {};
    }
  },
  methods: {
    onInput() {
      this.$emit('updated', this.data);
    }
  }
}
</script>
