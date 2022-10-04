export default [
  {
    path: 'estadisticas/oportunidades',
    name: 'admin.stats.opportunities',
    component: () => import(/* webpackChunkName: "admin-stats" */ '@/pages/Admin/Stats/OpportunitiesPage.vue'),
    meta: {
      title: 'Oportunidades'
    }
  },
  {
    path: 'estadisticas/oferentes',
    name: 'admin.stats.bidders',
    component: () => import(/* webpackChunkName: "admin-stats" */ '@/pages/Admin/Stats/BiddersPage.vue'),
    meta: {
      title: 'Oferentes'
    }
  },
  {
    path: 'estadisticas/conexiones',
    name: 'admin.stats.enrollments',
    component: () => import(/* webpackChunkName: "admin-stats" */ '@/pages/Admin/Stats/EnrollmentsPage.vue'),
    meta: {
      title: 'Conexiones'
    }
  },
  {
    path: 'estadisticas/candidatos',
    name: 'admin.stats.candidates',
    component: () => import(/* webpackChunkName: "admin-stats" */ '@/pages/Admin/Stats/CandidatesPage.vue'),
    meta: {
      title: 'Usuarios'
    }
  }
];
