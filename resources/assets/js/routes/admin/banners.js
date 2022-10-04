var apiUrl = 'admin/banners/:id?';

export default [
  {
    path: 'banners',
    name: 'admin.banners',
    component: () => import(/* webpackChunkName: "admin-banners" */ '@/pages/Admin/Banners/Index.vue'),
    meta: {
      title: 'Banners',
      apiUrl
    }
  },
  {
    path: 'banners/ordenar',
    name: 'admin.banners.sort',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Banners/Sortable.vue'),
    meta: {
      title: 'Banners',
      apiUrl
    }
  },
  {
    path: 'banners/crear',
    name: 'admin.banners.create',
    component: () => import(/* webpackChunkName: "admin-banners" */ '@/pages/Admin/Banners/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.banners',
      apiUrl
    }
  },
  {
    path: 'banners/edita/:id',
    name: 'admin.banners.edit',
    component: () => import(/* webpackChunkName: "admin-banners" */ '@/pages/Admin/Banners/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.banners',
      apiUrl
    }
  },
];
