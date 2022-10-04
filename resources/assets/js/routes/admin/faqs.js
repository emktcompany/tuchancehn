var apiUrl = 'admin/faqs/:id?';

export default [
  {
    path: 'faqs',
    name: 'admin.faqs',
    component: () => import(/* webpackChunkName: "admin-faqs" */ '@/pages/Admin/Faqs/Index.vue'),
    meta: {
      title: 'Preguntas Frequentes',
      apiUrl
    }
  },
  {
    path: 'faqs/crear',
    name: 'admin.faqs.create',
    component: () => import(/* webpackChunkName: "admin-faqs" */ '@/pages/Admin/Faqs/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.faqs',
      apiUrl
    }
  },
  {
    path: 'faqs/edita/:id',
    name: 'admin.faqs.edit',
    component: () => import(/* webpackChunkName: "admin-faqs" */ '@/pages/Admin/Faqs/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.faqs',
      apiUrl
    }
  },
];
