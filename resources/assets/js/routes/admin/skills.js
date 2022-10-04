var apiUrl = 'admin/skills/:id?';

export default [
  {
    path: 'habilidades',
    name: 'admin.skills',
    component: () => import(/* webpackChunkName: "admin-skills" */ '@/pages/Admin/Skills/Index.vue'),
    meta: {
      title: 'Habilidades',
      apiUrl
    }
  },
  {
    path: 'habilidades/crear',
    name: 'admin.skills.create',
    component: () => import(/* webpackChunkName: "admin-skills" */ '@/pages/Admin/Skills/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.skills',
      apiUrl
    }
  },
  {
    path: 'habilidades/edita/:id',
    name: 'admin.skills.edit',
    component: () => import(/* webpackChunkName: "admin-skills" */ '@/pages/Admin/Skills/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.skills',
      apiUrl
    }
  },
];
