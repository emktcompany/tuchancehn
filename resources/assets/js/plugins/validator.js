// import VeeValidate from 'vee-validate';
import { Validator, install as VeeValidate } from 'vee-validate/dist/vee-validate.minimal.esm.js';
import { required, min, max, min_value, max_value, email, digits, url, date_format, size, regex, numeric } from 'vee-validate/dist/rules.esm.js';

Validator.extend('date_format', date_format);
Validator.extend('digits', digits);
Validator.extend('email', email);
Validator.extend('min', min);
Validator.extend('max', max);
Validator.extend('min_value', min_value);
Validator.extend('max_value', max_value);
Validator.extend('regex', regex);
Validator.extend('required', required);
Validator.extend('size', size);
Validator.extend('url', url);
Validator.extend('numeric', numeric);

var messages = {
  _default: function(e) {
    return "Campo inválido."
  },
  // after: function(e, n) {
  //   var o = n[0];
  //   return "Ingresa un valor posterior " + (n[1] ? "o igual " : "") + "a " + o + "."
  // },
  // alpha_dash: function(e) {
  //   return "Ingresa solo letras, números y guiones."
  // },
  // alpha_num: function(e) {
  //   return "Ingresa solo letras y números."
  // },
  // alpha_spaces: function(e) {
  //   return "Ingresa solo letras y espacios."
  // },
  // alpha: function(e) {
  //   return "Ingresa solo letras."
  // },
  // before: function(e, n) {
  //   var o = n[0];
  //   return "Ingresa un valor anterior " + (n[1] ? "o igual " : "") + "a " + o + "."
  // },
  // between: function(e, n) {
  //   return "Ingresa un valor entre " + n[0] + " y " + n[1] + "."
  // },
  // confirmed: function(e) {
  //   return "El valor no coincide."
  // },
  // credit_card: function(e) {
  //   return "Tarjeta inválida."
  // },
  // date_between: function(e, n) {
  //   return "Ingresa una fecha entre " + n[0] + " y " + n[1] + "."
  // },
  date_format: function(e, n) {
    return "Ingresa una fecha válida."
  },
  // decimal: function(e, n) {
  //   void 0 === n && (n = []);
  //   var o = n[0];
  //   return void 0 === o && (o = "*"), "Ingresa un número con " + ("*" === o ? "" : o) + " decimales."
  // },
  digits: function(e, n) {
    return "Ingresa exactamente " + n[0] + " dígitos."
  },
  // dimensions: function(e, n) {
  //   return "Selecciona una imagen de " + n[0] + "x" + n[1] + "."
  // },
  email: function(e) {
    return "Ingresa un correo válido."
  },
  // ext: function(e) {
  //   return "Ingresa un archivo válido."
  // },
  image: function(e) {
    return "Ingresa una imagen."
  },
  // included: function(e) {
  //   return "Ingresa un valor válido."
  // },
  // integer: function(e) {
  //   return "Ingresa un entero."
  // },
  // ip: function(e) {
  //   return "Ingresa una dirección ip válida."
  // },
  // length: function(e, n) {
  //     var o = n[0],
  //         r = n[1];
  //     return r ? "El largo de este campo debe estar entre " + o + " y " + r + "." : "El largo de este campo debe ser " + o + "."
  // },
  max: function(e, n) {
    return "Ingresa no más de " + n[0] + " caracteres."
  },
  // max_value: function(e, n) {
  //   return "Ingresa un valor menor a " + n[0] + "."
  // },
  // mimes: function(e) {
  //   return "Ingresa un tipo de archivo válido."
  // },
  min: function(e, n) {
    return "Ingresa al menos " + n[0] + " caracteres."
  },
  // min_value: function(e, n) {
  //   return "Ingresa un valor superior a " + n[0] + "."
  // },
  // excluded: function(e) {
  //   return "Ingresa un valor válido."
  // },
  // numeric: function(e) {
  //   return "Ingresa solo caracteres numéricos."
  // },
  regex: function(e) {
    return "Ingresa un formato válido."
  },
  required: function(e) {
    return "Ingresa esta información."
  },
  size: function(e, n) {
    var o, r, t, a = n[0];
    return "El peso debe ser menor a " + (o = a, r = 1024, t = 0 == (o = Number(o) * r) ? 0 : Math.floor(Math.log(o) / Math.log(r)), 1 * (o / Math.pow(r, t)).toFixed(2) + " " + ["Byte", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"][t]) + "."
  },
  url: function(e) {
    return "Ingresa una URL válida."
  }
};

export default {
  install(Vue) {
    Vue.use(VeeValidate, {
      locale: 'es',
      dictionary: {
        es: { messages }
      }
    });
  }
}
