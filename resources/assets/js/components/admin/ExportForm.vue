<template lang="html">
  <form :action="action" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12" target="_blank">
    <input type="hidden" name="token" :value="$auth.token()">
    <form-field name="link" label="Selecciona un rango de fechas">
      <date-range-picker v-model="period" />
      <input type="hidden" name="from" :value="period.since">
      <input type="hidden" name="to" :value="period.until">
    </form-field>
    <slot></slot>
    <div class="text-right mt-6">
      <button type="submit" class="btn bg-teal text-white">Descargar</button>
    </div>
  </form>
</template>

<script>
import 'vue2-daterange-picker/dist/lib/vue-daterange-picker.min.css';

export default {
  props: {
    action: {
      type: String,
      require: true
    }
  },
  data () {
    return {
      period: {since: '7 days ago', until: null}
    }
  }
}
</script>
