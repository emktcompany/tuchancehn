import axios from 'axios';

import Vue from 'vue/dist/vue.runtime';
import VueCarousel from 'vue-carousel';
import VueTheMask from 'vue-the-mask';
import VueCollapse from 'vue2-collapse';
import VTooltip from 'v-tooltip';

import CountrySwitcher, {HasCountries} from './plugins/countries';
import TuChance, {HasCategories} from './plugins/tuchance';

Vue.use(require('@/plugins/router').default);
Vue.use(require('@/plugins/http').default, axios);
Vue.use(require('@/plugins/auth').default);
Vue.use(require('@/plugins/notifications').default);
Vue.use(require('@/plugins/validator').default);
Vue.use(require('@/plugins/loading').default);
Vue.use(require('@/plugins/dayjs').default);
Vue.use(require('@/plugins/directives').default);
Vue.use(require('@/plugins/google').default, '516789233223-2ok9cqi09d989pl9uf9chocmg4k6b983.apps.googleusercontent.com');
Vue.use(require('@/plugins/facebook').default, '583999928747491');
Vue.use(require('@/components').default);

Vue.use(VueCarousel);
Vue.use(VueCollapse);
Vue.use(VueTheMask);
Vue.use(VTooltip);

Vue.use(TuChance);
Vue.use(CountrySwitcher);

export default new Vue({
  mixins:  [HasCountries, HasCategories],
  mounted: function () {
    this.$emit('loading-done');
  },
  router:  Vue.router,
  render:  h => h(require('@/components/App.vue'))
});
