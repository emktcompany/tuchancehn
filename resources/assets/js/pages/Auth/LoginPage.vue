<template lang="html">
  <section class="relative pt-24 md:pt-32">
    <div class="container">
      <div class="flex flex-col md:flex-row justify-between md:pt-12 pb-12">
        <div class="w-full md:w-1/2 py-8 text-center md:text-left text-shadow-dense md:text-shadow-none">
          <breadcrumbs-list text-color="text-white" />
          <div class="font-dosis text-5xl lg:text-6xl text-white pt-4 md:pt-12">
            <div>Es tu momento.</div>
            <div>Es tu decisión.</div>
            <div>¡Comienza hoy!</div>
          </div>
        </div>
        <div class="w-full md:w-1/2 flex justify-center">
          <div class="w-full max-w-xs p-6 sm:p-12 bg-white">
            <div class="font-dosis font-bold text-3xl text-purple mb-6">Inicia Sesión</div>
            <login-form />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
