<template lang="html">
  <div class="relative bg-blue overflow-hidden">
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
    <div class="relative">
      <transition mode="out-in"
        enter-active-class="animated-fast animated fadeIn"
        leave-active-class="animated-fast animated fadeOut">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
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
