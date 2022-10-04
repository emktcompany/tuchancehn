var apiUrl = 'admin/interests/:id?';

export default [
  {
    path: 'intereses',
    name: 'admin.interests',
    component: () => import(/* webpackChunkName: "admin-interests" */ '@/pages/Admin/Interests/Index.vue'),
    meta: {
      title: 'Industrias',
      apiUrl
    }
  },
  {
    path: 'intereses/crear',
    name: 'admin.interests.create',
    component: () => import(/* webpackChunkName: "admin-interests" */ '@/pages/Admin/Interests/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.interests',
      apiUrl
    }
  },
  {
    path: 'intereses/edita/:id',
    name: 'admin.interests.edit',
    component: () => import(/* webpackChunkName: "admin-interests" */ '@/pages/Admin/Interests/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.interests',
      apiUrl
    }
  },
];
