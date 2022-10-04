<template lang="html">
  <label class="file-container block overflow-hidden relative">
    <button type="button" class="btn bg-purple text-white text-xs px-6 block w-full text-center">{{text}}</button>
    <input @change="setFile" type="file">
  </label>
</template>

<script>
export default {
  props: {
    value: {
      required: true
    },
    isImage: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    text() {
      return this.value ? this.value.name : 'Cambiar';
    }
  },
  methods: {
    setFile(e) {
      const file = e.target.files.length > 0 ? e.target.files[0] : null;

      this.$emit('input', file);

      if (file && this.isImage) {
        this.readImage(file);
      }
    },
    readImage(file) {
      var reader;

      if (!file.type.includes('image/')) {
        this.$notify({
          title: 'Error',
          text: 'Selecciona una imagen',
          type: 'error'
        });

        this.$emit('preview', null);

        return;
      }

      if (typeof FileReader === 'function') {
        reader = new FileReader;
        reader.onload = (event) => {
          this.$emit('preview', event.target.result);
        };
        reader.readAsDataURL(file);
      } else {
        alert('Sorry, FileReader API not supported');
      }
    }
  }
}
</script>
