import Static from '@/pages/StaticPage.vue';

export default [
  {
    name: 'about',
    path: '/acerca',
    component: Static,
    meta: {
      title: '¿Quiénes Somos?'
    },
    props: {
      content: require('@/content/about.html')
    }
  },
  {
    name: 'terms',
    path: '/terminos',
    component: Static,
    meta: {
      title: 'Términos y condiciones'
    },
    props: {
      content: require('@/content/terms.html'),
      hideImage: true
    }
  },
  {
    name: 'impressum',
    path: '/impressum',
    component: Static,
    meta: {
      title: 'Impressum'
    },
    props: {
      content: require('@/content/impressum.html'),
      hideImage: true
    }
  }
];
