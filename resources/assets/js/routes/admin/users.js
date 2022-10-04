var apiUrl = 'admin/users/:id?';

export default [
  {
    path: 'usuarios',
    name: 'admin.users',
    component: () => import(/* webpackChunkName: "admin-users" */ '@/pages/Admin/Users/Index.vue'),
    meta: {
      title: 'Usuarios',
      apiUrl
    }
  },
  {
    path: 'usuarios/crear',
    name: 'admin.users.create',
    component: () => import(/* webpackChunkName: "admin-users" */ '@/pages/Admin/Users/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.users',
      apiUrl
    }
  },
  {
    path: 'usuarios/edita/:id',
    name: 'admin.users.edit',
    component: () => import(/* webpackChunkName: "admin-users" */ '@/pages/Admin/Users/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.users',
      apiUrl
    }
  },
];
