<template lang="html">
  <section class="h-screen bg-blue text-white flex items-center justify-center text-center relative overflow-hidden">
    <div class="absolute pin">
      <div class="container relative h-full">
        <div class="absolute dot-cyan">
          <div class="dot bg-cyan animated zoomIn"></div>
        </div>
        <div class="absolute dot-red">
          <div class="dot bg-red animated zoomIn"></div>
        </div>
        <div class="absolute dot-teal">
          <div class="dot bg-teal animated zoomIn"></div>
        </div>
      </div>
    </div>
    <div class="p-8 relative">
      <p class="font-dosis">{{error}}</p>
      <div class="h-px bg-white my-8"></div>
      <p class="text-2xl font-thin">{{ message }}</p>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    error: {
      required: true
    },
    message: {
      required: true
    }
  }
}
</script>

<style lang="scss" scoped>
  .font-dosis {
    font-size: 144px;
  }
    .dot-cyan {
      top: 157px;
      left: 50%;
      margin-left: 6%;
    }
    .dot-red {
      top: 60%;
      left: 50%;
      margin-left: -75px;
      .dot {
        width: 66px;
        height: 66px;
      }
    }
    .dot-teal {
      top: 60%;
      right: -30px;
      .dot {
        width: 290px;
        height: 290px;
      }
    }
</style>
