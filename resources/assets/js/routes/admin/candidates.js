var apiUrl = 'admin/candidates/:id?';

export default [
  {
    path: 'candidatos',
    name: 'admin.candidates',
    component: () => import(/* webpackChunkName: "admin-candidates" */ '@/pages/Admin/Candidates/Index.vue'),
    meta: {
      title: 'Usuarios',
      apiUrl
    }
  },
  {
    path: 'candidatos/importar',
    name: 'admin.candidates.import',
    component: () => import(/* webpackChunkName: "admin-candidates" */ '@/pages/Admin/Candidates/Import.vue'),
    meta: {
      title: 'Importar',
      parent: 'admin.candidates',
      apiUrl
    }
  },
  {
    path: 'candidatos/descargar',
    name: 'admin.candidates.download',
    component: () => import(/* webpackChunkName: "admin-candidates" */ '@/pages/Admin/Candidates/Export.vue'),
    meta: {
      title: 'Descargar',
      parent: 'admin.candidates',
      apiUrl
    }
  },
  {
    path: 'candidatos/crear',
    name: 'admin.candidates.create',
    component: () => import(/* webpackChunkName: "admin-candidates" */ '@/pages/Admin/Candidates/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.candidates',
      apiUrl
    }
  },
  {
    path: 'candidatos/edita/:id',
    name: 'admin.candidates.edit',
    component: () => import(/* webpackChunkName: "admin-candidates" */ '@/pages/Admin/Candidates/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.candidates',
      apiUrl
    }
  },
];
