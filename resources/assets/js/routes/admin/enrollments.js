var apiUrl = 'admin/enrollments/:id?';

export default [
  {
    path: 'conexiones',
    name: 'admin.enrollments',
    component: () => import(/* webpackChunkName: "admin-enrollments" */ '@/pages/Admin/Enrollments/Index.vue'),
    meta: {
      title: 'Conexiones',
      apiUrl
    }
  },
  {
    path: 'conexiones/descargar',
    name: 'admin.enrollments.download',
    component: () => import(/* webpackChunkName: "admin-enrollments" */ '@/pages/Admin/Enrollments/Export.vue'),
    meta: {
      title: 'Descargar',
      parent: 'admin.enrollments',
      apiUrl
    }
  },
];
