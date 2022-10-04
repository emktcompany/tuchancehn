<template lang="html">
  <div>
    <div class="mb-4 mx-auto overflow-hidden relative">
      <div class="bg-cyan" :style="style"></div>
      <img :src="preview" alt="" class="absolute pin w-full h-full" v-if="preview">
    </div>

    <file-input :is-image="true" v-model="file" @input="onInput" @preview="cropper=$event" />

    <cropper-modal v-model="crop" :image="cropper" v-if="cropper" @cropped="setPreview" @input="onInput" @discard="cropper=null" :aspect-ratio="ratio" />
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
    },
    ratio: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      crop: null,
      file: null,
      cropper: null,
      image: null
    };
  },
  computed: {
    preview() {
      var _default = !this.default ? null : (this.default.url || this.default);
      return this.image || _default;
    },
    style() {
      var ratio = (1 / this.ratio) * 100;
      return {
        'height': '1px',
        'padding-bottom': String(ratio) + '%',
        'border-radius': ratio == 100 ? '50%' : '6px'
      }
    }
  },
  methods: {
    onInput() {
      var value = null;

      if (this.crop && this.file) {
        value = Object.assign({
          file: this.file
        }, this.crop);
      }

      this.$emit('input', value);
    },
    setFile($event) {
      this.file = $event;

      if (!$event) {
        this.image = null;
      }

      this.onInput();
    },
    setPreview($event) {
      this.image = $event;

      this.onInput();
    }
  }
}
</script>
