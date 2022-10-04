import dayjs from 'dayjs';
import advancedFormat from 'dayjs/plugin/advancedFormat';
import 'dayjs/locale/es';

dayjs.locale('es');
dayjs.extend(advancedFormat);

export default {
  install(Vue) {
    Vue.filter('date', (date, format = "DD/MMM/YYYY") => {
      return dayjs(date).format(format);
    });

    Object.defineProperty(Vue.prototype, '$dayjs', {
      get() {
        return dayjs;
      }
    });
  }
}
