<template lang="html">
  <div class="bg-orange rounded-b text-white px-4 py-6 shadow" role="alert">
    <div class="flex">
      <div class="py-1"><svg-icon src="~@svg/icon-alert.svg" class="fill-current h-6 w-6 mr-4"></svg-icon></div>
      <div>
        <p class="font-bold text-4xl font-dosis">{{title}}</p>
        <p class="font-thin mt-4 text-lg">{{message}}</p>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    message: {
      type: String,
      required: true
    },
    title: {
      type: String,
      default: 'No hay resultados'
    }
  }
}
</script>
