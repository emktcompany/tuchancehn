<template></template>

<script>
import isUndefined from 'lodash/isUndefined';
import {compile} from 'path-to-regexp';

import {resolve, http} from '@/plugins/http';

import SavesRow from '@/mixins/admin/SavesRow';
import FocusesOnError from '@/mixins/FocusesOnError';

var url;
var getRow = function (to, next, vm = null) {
  return resolve({
    row() {
      url = compile(to.meta.apiUrl);

      if (to.params.row) {
        return Promise.resolve({
          data: {
            data: to.params.row
          }
        });
      }

      if (to.params.id) {
        return http.get(url({id: to.params.id}));
      }

      return Promise.resolve(null);
    }
  }, next, vm);
};

export default {
  mixins: [FocusesOnError, SavesRow],
  beforeRouteEnter (to, from, next) {
    getRow(to, next);
  },
  beforeRouteUpdate (to, from, next) {
    getRow(to, next, this);
  },
  data() {
    return {
      row: {data: {}}
    };
  },
  methods: {
    url(data) {
      return url(data);
    },
    async submit() {
      try {
        var response = await this.save();

        this.$notify({
          title: 'Éxito',
          text: 'Cambios guardados con éxito',
          type: 'success'
        });

        this.saved(response.data);
      } catch (e) {
        if (e.message == 'invalid') {
          this.focusOnError();
        } else {
          this.$notify({
            title: 'Error',
            text: 'Error al guardar los cambios',
            type: 'error'
          });
        }
      }
    },
    resolved(values) {
      if (values.row === null || isUndefined(values.row)) {
        this.reset();
      }

      this.injected(values);
    },
    reset() {
      this.row = {data: {}};
    },
    injected() {},
    saved(response) {}
  }
}
</script>
