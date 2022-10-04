<template lang="html">
  <nav class="flex flex-col">
    <ul class="list-reset pb-1 bg-purple rounded">
      <admin-menu-item @clicked="$emit('clicked')" more-class="bg-purple-dark text-white hover:bg-purple-darker" :link-class="link.className ? link.className : 'bg-purple hover:bg-purple-dark p-3 text-white'" :active-class="link.className ? link.className : 'bg-purple-dark hover:bg-purple-darker p-3 text-white'" v-for="(link, i) in menu" :key="`link-${i}`" :link="link" />
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      menu: [
        {icon: require('@svg/icons/solid/home.svg'), label: 'Dashboard', route: {name: 'admin.dashboard'}, className: 'font-dosis font-bold text-white bg-cyan hover:bg-blue px-3 py-6 rounded-t', check: {only: ['admin']} },
        {icon: require('@svg/icons/solid/bullhorn.svg'), label: 'Sube tu Oportunidad', className: 'font-dosis font-bold text-white bg-cyan hover:bg-blue px-3 py-6 rounded-t', route: {name: 'admin.opportunities.create'}, check: {only: ['bidder']} },
        {icon: require('@svg/icons/solid/home.svg'), label: 'Dashboard', route: {name: 'admin.dashboard'}, check: {only: ['bidder']} },
        {icon: require('@svg/icons/solid/user.svg'), label: 'Administradores', route: {name: 'admin.users'}, check: {only: ['admin']}, children: [
          {label: 'Todos', route: {name: 'admin.users'}},
          {label: 'Agregar', route: {name: 'admin.users.create'}},
        ]},
        {icon: require('@svg/icons/solid/user-graduate.svg'), label: 'Usuarios', route: {name: 'admin.candidates'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.candidates'}},
          {label: 'Agregar', route: {name: 'admin.candidates.create'}},
          {label: 'Importar', route: {name: 'admin.candidates.import'}},
          {label: 'Descargar', route: {name: 'admin.candidates.download'}}
        ]},
        {icon: require('@svg/icons/solid/user-tie.svg'), label: 'Oferentes', route: {name: 'admin.bidders'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.bidders'}},
          {label: 'Agregar', route: {name: 'admin.bidders.create'}},
          {label: 'Descargar', route: {name: 'admin.bidders.download'}}
        ]},
        {icon: require('@svg/icons/solid/bullhorn.svg'), label: 'Oportunidades', route: {name: 'admin.opportunities'}, children: [
          {label: 'Todos', route: {name: 'admin.opportunities'}},
          {label: 'Agregar', route: {name: 'admin.opportunities.create'}},
          {label: 'Importar', route: {name: 'admin.opportunities.import'}},
          {label: 'Descargar', route: {name: 'admin.opportunities.download'}}
        ]},
        {icon: require('@svg/icons/solid/share.svg'), label: 'Conexiones', route: {name: 'admin.enrollments'}, children: [
          {label: 'Todos', route: {name: 'admin.enrollments'}},
          {label: 'Descargar', route: {name: 'admin.enrollments.download'}}
        ]},
        {icon: require('@svg/icons/solid/tag.svg'), label: 'Categorías', route: {name: 'admin.categories'}, check: {only: ['admin']}, children: [
          {label: 'Todos', route: {name: 'admin.categories'}},
          {label: 'Agregar', route: {name: 'admin.categories.create'}},
          {label: 'Ordenar', route: {name: 'admin.categories.sort'}},
        ]},
        {icon: require('@svg/icons/solid/images.svg'), label: 'Banners', route: {name: 'admin.banners'}, check: {only: ['admin']}, children: [
          {label: 'Todos', route: {name: 'admin.banners'}},
          {label: 'Agregar', route: {name: 'admin.banners.create'}},
          {label: 'Ordenar', route: {name: 'admin.banners.sort'}},
        ]},
        {icon: require('@svg/icons/solid/images.svg'), label: 'Correos electrónicos', route: {name: 'admin.email-templates'}, check: {only: ['admin']}, children: [
          {label: 'Todos', route: {name: 'admin.email-templates'}},
          {label: 'Agregar', route: {name: 'admin.email-templates.create'}},
        ]},
        {icon: require('@svg/icons/solid/comment.svg'), label: 'Testimoniales', route: {name: 'admin.testimonials'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.testimonials'}},
          {label: 'Agregar', route: {name: 'admin.testimonials.create'}},
          {label: 'Ordenar', route: {name: 'admin.testimonials.sort'}},
        ]},
        {icon: require('@svg/icons/solid/industry.svg'), label: 'Industrias', route: {name: 'admin.interests'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.interests'}},
          {label: 'Agregar', route: {name: 'admin.interests.create'}},
        ]},
        {icon: require('@svg/icons/solid/question-circle.svg'), label: 'Preguntas Frecuentes', route: {name: 'admin.faqs'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.faqs'}},
          {label: 'Agregar', route: {name: 'admin.faqs.create'}},
        ]},
        {icon: require('@svg/icons/solid/lightbulb.svg'), label: 'Habilidades', route: {name: 'admin.skills'}, check: {except: ['bidder']}, children: [
          {label: 'Todos', route: {name: 'admin.skills'}},
          {label: 'Agregar', route: {name: 'admin.skills.create'}},
        ]},
      ]
    };
  }
}
</script>
