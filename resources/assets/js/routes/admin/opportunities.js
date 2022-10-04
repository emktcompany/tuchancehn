var apiUrl = 'admin/opportunities/:id?';

export default [
  {
    path: 'oportunidades',
    name: 'admin.opportunities',
    component: () => import(/* webpackChunkName: "admin-opportunities" */ '@/pages/Admin/Opportunities/Index.vue'),
    meta: {
      title: 'Oportunidades',
      apiUrl
    }
  },
  {
    path: 'oportunidades/importar',
    name: 'admin.opportunities.import',
    component: () => import(/* webpackChunkName: "admin-opportunities" */ '@/pages/Admin/Opportunities/Import.vue'),
    meta: {
      title: 'Importar',
      parent: 'admin.opportunities',
      apiUrl
    }
  },
  {
    path: 'oportunidades/descargar',
    name: 'admin.opportunities.download',
    component: () => import(/* webpackChunkName: "admin-opportunities" */ '@/pages/Admin/Opportunities/Export.vue'),
    meta: {
      title: 'Descargar',
      parent: 'admin.opportunities',
      apiUrl
    }
  },
  {
    path: 'oportunidades/crear',
    name: 'admin.opportunities.create',
    component: () => import(/* webpackChunkName: "admin-opportunities" */ '@/pages/Admin/Opportunities/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.opportunities',
      apiUrl
    }
  },
  {
    path: 'oportunidades/edita/:id',
    name: 'admin.opportunities.edit',
    component: () => import(/* webpackChunkName: "admin-opportunities" */ '@/pages/Admin/Opportunities/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.opportunities',
      apiUrl
    }
  },
];
