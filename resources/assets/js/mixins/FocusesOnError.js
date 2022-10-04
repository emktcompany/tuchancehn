import each from 'lodash/each';
import find from 'lodash/find';

export default {
  methods: {
    focusOnError() {
      find(this.$validator.errors.items, (error) => {
        var name = error.field, elem;

        if (elem = this.$el.querySelector(`[name="${name}"]`)) {
          try {
            elem.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
            elem.focus();
          } catch (e) {
            console.error(e);
          }
        }

        return !!elem;
      });
    }
  }
}
