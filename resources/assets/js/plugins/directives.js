import ClickOutside from 'vue-click-outside';
// import Rellax from 'rellax';
import Ripple from 'vue-ripple-directive';

Ripple.color = 'rgba(255, 255, 255, 0.35)';

export default {
  install(Vue) {
    Vue.directive('click-outside', ClickOutside);
    Vue.directive('ripple', Ripple);
    // Vue.directive('rellax', function (element) {
    //   new Rellax(element);
    // });
  }
}
