<template lang="html">
  <div>
    <div class="w-32 h-32 bg-cyan mb-4 mx-auto overflow-hidden relative">
      <img :src="preview" alt="" class="absolute pin w-full h-full p-2" v-if="preview">
    </div>

    <file-input :is-image="true" v-model="file" @input="onInput" @preview="image=$event" />
  </div>
</template>

<script>
export default {
  props: {
    value: {
      required: true
    },
    default: {
      default: null
    }
  },
  data() {
    return {
      file: null,
      image: null
    };
  },
  computed: {
    preview() {
      var _default = !this.default ? null : (this.default.url || this.default);
      return this.image || _default;
    }
  },
  methods: {
    onInput() {
      if (this.file) {
        this.$emit('input', this.file);
      } else {
        this.$emit('input', null);
      }
    }
  }
}
</script>
