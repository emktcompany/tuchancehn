var apiUrl = 'admin/bidders/:id?';

export default [
  {
    path: 'oferentes',
    name: 'admin.bidders',
    component: () => import(/* webpackChunkName: "admin-bidders" */ '@/pages/Admin/Bidders/Index.vue'),
    meta: {
      title: 'Oferentes',
      apiUrl
    }
  },
  {
    path: 'oferentes/descargar',
    name: 'admin.bidders.download',
    component: () => import(/* webpackChunkName: "admin-bidders" */ '@/pages/Admin/Bidders/Export.vue'),
    meta: {
      title: 'Descargar',
      parent: 'admin.bidders',
      apiUrl
    }
  },
  {
    path: 'oferentes/crear',
    name: 'admin.bidders.create',
    component: () => import(/* webpackChunkName: "admin-bidders" */ '@/pages/Admin/Bidders/Form.vue'),
    meta: {
      title: 'Crear',
      parent: 'admin.bidders',
      apiUrl
    }
  },
  {
    path: 'oferentes/edita/:id',
    name: 'admin.bidders.edit',
    component: () => import(/* webpackChunkName: "admin-bidders" */ '@/pages/Admin/Bidders/Form.vue'),
    meta: {
      title: 'Editar',
      parent: 'admin.bidders',
      apiUrl
    }
  },
];
