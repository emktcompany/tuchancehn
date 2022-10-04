<template lang="html">
  <transition name="fade">
    <div class="fixed pin z-50">
      <div class="absolute pin bg-black opacity-75"></div>
      <div class="relative h-full flex items-center justify-center p-8">
        <div class="max-w-lg bg-white p-8">
          <div class="pb-8">
            <vue-cropper
              ref='cropper'
              :guides="true"
              :view-mode="2"
              drag-mode="move"
              :aspect-ratio="aspectRatio"
              :auto-crop-area="1"
              :min-container-width="minWidth"
              :min-container-height="minHeight"
              :background="false"
              :rotatable="false"
              :src="image"
              :crop="onCrop"
              alt="Source Image" />
          </div>
          <div class="text-center">
            <button type="button" @click="$emit('discard')" class="btn bg-grey-light text-grey-dark px-4">Cancelar</button>
            <button type="button" @click="crop" class="btn bg-teal text-white px-4">Utilizar Imagen</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import VueCropper from 'vue-cropperjs';
export default {
  components: {VueCropper},
  props: {
    value: {
      required: true
    },
    image: {
      required: true
    },
    aspectRatio: {
      required: false,
      type: Number,
      default: null
    },
    minWidth: {
      required: false,
      type: Number,
      default: 200
    },
    minHeight: {
      required: false,
      type: Number,
      default: 200
    }
  },
  methods: {
    onCrop() {
      this.$emit('input', this.$refs.cropper.getData());
    },
    crop() {
      this.$emit('input', this.$refs.cropper.getData());
      this.$emit('cropped', this.$refs.cropper.getCroppedCanvas().toDataURL());
      this.$emit('discard');
    }
  }
}
</script>
