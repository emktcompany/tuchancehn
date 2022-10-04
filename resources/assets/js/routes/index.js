import Index from '@/pages/IndexPage.vue';
import ErrorPage from '@/pages/ErrorPage.vue';
import Layout from '@/components/layouts/AppLayout.vue';
import Home from '@/pages/HomePage.vue';

const routes = [
  {
    name: 'index',
    path: '/',
    component: Home,
    meta: {
      title: 'Inicio',
      hideSearch: true
    }
  },
  {
    name: '404',
    path: '/404',
    component: ErrorPage,
    props: {
      error: '404',
      message: 'No encontramos la página que buscas'
    },
    meta: {
      transparentHeader: true
    }
  }
];

export default routes
  .concat(require('./app').default)
  .concat(require('./auth').default)
  .concat(require('./content').default)
  .concat(require('./admin').default);
