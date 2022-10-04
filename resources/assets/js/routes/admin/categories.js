var apiUrl = 'admin/categories/:id?';

export default [
  {
    path: 'categorias',
    name: 'admin.categories',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Categories/Index.vue'),
    meta: {
      title: 'Categorías',
      apiUrl
    }
  },
  {
    path: 'categorias/ordenar',
    name: 'admin.categories.sort',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Categories/Sortable.vue'),
    meta: {
      title: 'Categorías',
      apiUrl
    }
  },
  {
    path: 'categorias/crear',
    name: 'admin.categories.create',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Categories/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.categories',
      apiUrl
    }
  },
  {
    path: 'categorias/edita/:id',
    name: 'admin.categories.edit',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Categories/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.categories',
      apiUrl
    }
  },
];
