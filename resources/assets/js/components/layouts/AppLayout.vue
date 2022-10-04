<template lang="html">
  <transition mode="out-in"
    enter-active-class="animated-fast animated fadeIn"
    leave-active-class="animated-fast animated fadeOut">
    <router-view></router-view>
  </transition>
</template>

<script>
export default {
}
</script>
