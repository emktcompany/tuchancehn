<template lang="html">
  <div class="h-screen bg-blue"></div>
</template>

<script>
export default {
  mounted() {
    this.$router.replace({
      name: 'home'
    });
  }
}
</script>
