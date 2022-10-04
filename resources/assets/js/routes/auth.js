
export default [
  {
    path: '/cuenta',
    component: () => import(/* webpackChunkName: "auth" */ '@/components/layouts/AuthLayout.vue'),
    children: [
      {
        name: 'account',
        path: '',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/AccountPage.vue'),
        meta: {
          auth: true,
          title: 'Mi Cuenta'
        },
      },
      {
        name: 'settings',
        path: 'configuracion',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/SettingsPage.vue'),
        meta: {
          auth: true,
          title: 'Configuración'
        },
      },
      {
        name: 'my-opportunities',
        path: 'oportunidades',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/OpportunitiesPage.vue'),
        meta: {
          auth: true,
          title: 'Oportunidades'
        },
      },
      {
        name: 'login',
        path: 'login',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/LoginPage.vue'),
        meta: {
          auth: false,
          title: 'Iniciar Sesión',
          transparentHeader: true
        }
      },
      {
        name: 'remind',
        path: 'recuperar',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/RemindPage.vue'),
        meta: {
          auth: false,
          title: 'Recuperar Contraseña',
          transparentHeader: true
        }
      },
      {
        name: 'reset',
        path: 'reset/:token',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/ResetPage.vue'),
        meta: {
          auth: false,
          title: 'Recuperar Contraseña',
          transparentHeader: true
        }
      },
      {
        // name: 'register',
        path: 'registro',
        component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/RegisterPage.vue'),
        meta: {
          auth: false,
          title: 'Registro',
          transparentHeader: true,
          navigateToCountry: false
        },
        children: [
          {
            name: 'register.default',
            path: '',
            component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/Register/SelectForm.vue'),
            meta: {
              transparentHeader: true
            }
          },
          {
            name: 'register.candidate',
            path: 'candidato',
            component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/Register/CandidateForm.vue'),
            meta: {
              title: 'Usuario',
              transparentHeader: true
            }
          },
          {
            name: 'register.bidder',
            path: 'oferente',
            component: () => import(/* webpackChunkName: "auth" */ '@/pages/Auth/Register/BidderForm.vue'),
            meta: {
              title: 'Oferente',
              transparentHeader: true
            }
          }
        ]
      }
    ]
  }
];
