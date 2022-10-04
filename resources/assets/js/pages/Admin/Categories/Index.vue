<template lang="html">
  <div class="py-8">
    <index-view ref="index" :url="url" title="Categorías" :filters="false">
      <div class="flex-1 flex xs:flex-wrap no-underline text-grey-darker items-center p-4" slot="item" slot-scope="item">
        <div class="xs:w-full sm:flex-1 xs:pb-2">
          <p class="text-red font-bold font-dosis mb-2">
            {{item.row.name}}
          </p>
          <p class="text-grey-dark text-xs">
            <toggle-pill :active="!!item.row.is_active" />
          </p>
        </div>
        <div class="flex-none w-24 xs:w-1/2 sm:text-center">
          <span class="font-dosis text-xs">{{ item.row.created_at | date }}</span>
        </div>
      </div>

      <template slot="item-actions" slot-scope="item">
        <router-link :to="{name: 'admin.categories.edit', params: { id: item.row.id }}" class="outline-none focus:outline-none p-2 appearance-none flex items-center" v-tooltip.top-center="'Editar'"><svg-icon src="~@svg/icons/regular/edit.svg" class="block fill-current w-4 h-4" /></router-link>
        <toggle-button @toggled="item.row.is_active=$event" :active="!!item.row.is_active" :url="$refs['index'].parseUrl({id: item.row.id, toggle: 'active'})" />
      </template>

      <template slot="actions">
        <router-link :to="{name: 'admin.categories.create'}" class="btn bg-teal uppercase text-white">Agregar</router-link>
        <router-link :to="{name: 'admin.categories.sort'}" class="btn bg-blue uppercase text-white">Ordenar</router-link>
      </template>
    </index-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: '/admin/categories/:id?/:toggle?'
    }
  }
}
</script>
