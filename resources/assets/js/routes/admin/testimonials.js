var apiUrl = 'admin/testimonials/:id?';

export default [
  {
    path: 'testimoniales',
    name: 'admin.testimonials',
    component: () => import(/* webpackChunkName: "admin-testimonials" */ '@/pages/Admin/Testimonials/Index.vue'),
    meta: {
      title: 'Testimoniales',
      apiUrl
    }
  },
  {
    path: 'testimoniales/ordenar',
    name: 'admin.testimonials.sort',
    component: () => import(/* webpackChunkName: "admin-categories" */ '@/pages/Admin/Testimonials/Sortable.vue'),
    meta: {
      title: 'Testimoniales',
      apiUrl
    }
  },
  {
    path: 'testimoniales/crear',
    name: 'admin.testimonials.create',
    component: () => import(/* webpackChunkName: "admin-testimonials" */ '@/pages/Admin/Testimonials/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.testimonials',
      apiUrl
    }
  },
  {
    path: 'testimoniales/edita/:id',
    name: 'admin.testimonials.edit',
    component: () => import(/* webpackChunkName: "admin-testimonials" */ '@/pages/Admin/Testimonials/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.testimonials',
      apiUrl
    }
  },
];
