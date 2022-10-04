<template lang="html">
  <select v-bind:value="value" v-on:change="$emit('input', $event.target.value)" :name="name" :id="id" :class="value?'':'text-grey-dark'">
    <option :value="null" v-if="empty">{{emptyText}}</option>
    <option :value="option[valueKey]" v-for="(option, i) in options">{{option[labelKey]}}</option>
  </select>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    id: {
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
    empty: {
      default: false
    }
  }
}
</script>
