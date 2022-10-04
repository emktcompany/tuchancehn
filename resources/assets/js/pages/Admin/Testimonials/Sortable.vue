<template lang="html">
  <div class="py-8">
    <sortable-view ref="index" :url="url" title="Testimoniales">
      <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4" slot="item" slot-scope="item">
        <div class="xs:w-full sm:flex-1 xs:pb-2">
          <p class="text-red font-bold font-dosis">
            {{item.row.name}}
          </p>
        </div>
        <div class="flex-none w-24 xs:w-1/2 sm:text-center">
          <span class="font-dosis text-xs">{{ item.row.created_at | date }}</span>
        </div>
      </div>

      <template slot="actions">
        <router-link :to="{name: 'admin.testimonials'}" class="btn bg-grey-light uppercase text-grey-dark">Regresar</router-link>
      </template>
    </sortable-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: '/admin/testimonials/sort'
    }
  }
}
</script>
