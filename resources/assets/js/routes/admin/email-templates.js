var apiUrl = 'admin/email-templates/:id?';

export default [
  {
    path: 'emails',
    name: 'admin.email-templates',
    component: () => import(/* webpackChunkName: "admin-email-templates" */ '@/pages/Admin/EmailTemplates/Index.vue'),
    meta: {
      title: 'Categorías',
      apiUrl
    }
  },
  {
    path: 'emails/crear',
    name: 'admin.email-templates.create',
    component: () => import(/* webpackChunkName: "admin-email-templates" */ '@/pages/Admin/EmailTemplates/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.email-templates',
      apiUrl
    }
  },
  {
    path: 'emails/edita/:id',
    name: 'admin.email-templates.edit',
    component: () => import(/* webpackChunkName: "admin-email-templates" */ '@/pages/Admin/EmailTemplates/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.email-templates',
      apiUrl
    }
  },
];
