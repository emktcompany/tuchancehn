<template lang="html">
  <div class="relative group flex items-center" :class="focused ? 'focus' : ''">
    <div class="flex-none" v-if="code">
      (+{{code}})
    </div>
    <input autocomplete="off" v-on:input="$emit('input', $event.target.value)" v-bind:value="value" class="naked-form-field px-2 flex-1" type="text" @focus="focused=true" @blur="focused=false">
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        required: true
      },
      country: {
        type: Object,
        required: false
      }
    },
    data() {
      return {
        focused: false,
        codes: {
          sv: 503,
          gt: 502,
          hn: 504,
          ni: 505,
          cr: 506,
        }
      };
    },
    computed: {
      code() {
        var country = this.country || this.$country;
        return country && country.code ? this.codes[country.code] : false;
      }
    },
  }
</script>
