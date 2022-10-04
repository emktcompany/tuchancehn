<template lang="html">
  <div class="flex items-center justify-end">
    <div :class="buttonContainerClass">
      <a href @click.prevent="toggle" class="no-underline block" :class="buttonClass">
        <div class="icon overflow-hidden w-8 h-8 relative">
          <div class="absolute pin-t pin-x" :class="{'-mt-8': open}">
            <div class="flex items-center justify-center w-8 h-8">
              <svg-icon class="fill-none stroke-current" src="~@svg/search-icon.svg"></svg-icon>
            </div>
            <div class="flex items-center justify-center w-8 h-8">
              <svg-icon class="fill-none stroke-current" src="~@svg/close-icon.svg"></svg-icon>
            </div>
          </div>
        </div>
      </a>
    </div>
    <transition name="search-bar"
      @after-enter="afterEnter"
      @after-leave="afterLeave">
      <div :class="inputContainerClass" class="overflow-hidden" v-show="open">
        <div :class="inputWrapperClass">
          <input type="text" class="w-full leading-none font-light outline-none focus:outline-none" :placeholder="placeholder" :class="inputClass" v-model="term">
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import debounce from 'lodash/debounce';

export default {
  props: {
    placeholder: {
      type: String,
      default: 'Buscar'
    },
    buttonClass: {
      type: String,
      default: ''
    },
    buttonContainerClass: {
      type: String,
      default: 'flex-none'
    },
    inputClass: {
      type: String,
      default: 'bg-transparent border-b border-white text-white md:text-2xl p-2'
    },
    inputContainerClass: {
      type: String,
      default: 'w-full md:w-1/2 md:flex-none'
    },
    inputWrapperClass: {
      type: String,
      default: 'pl-4'
    }
  },
  data() {
    return {
      term: '',
      open: false
    }
  },
  mounted() {
    this.infer(this.$route)
  },
  watch: {
    term: debounce(function (term) {
      var name = this.$route.name || 'opportunities';

      if (['opportunities', 'bidders', 'category'].indexOf(name) < 0) {
        name = 'opportunities';
      }

      if (name == 'category' && this.$route.params.category != 'cursos-en-linea') {
        name = 'opportunities';
      }

      if (term) {
        this.$router.push({
          name,
          query: {term}
        })
      } else {
        this.$router.push({
          name
        })
      }
    }, 500),
    $route(to) {
      this.infer(to);
    }
  },
  methods: {
    toggle() {
      if (!this.open) {
        this.$emit('toggled', true);
        this.open = true;
      } else {
        this.open = false;
      }
    },
    afterLeave() {
      this.$emit('toggled', false);
    },
    afterEnter() {
      this.$el.querySelector('input[type="text"]').focus();
    },
    infer(to) {
      if (to.query.term) {
        if (to.query.term != this.term) this.term = to.query.term;
        if (!this.open) this.toggle();
      } else {
        this.term = '';
        if (this.open) this.toggle();
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.icon .absolute {
  transition: margin-top .15s ease;
  transition-delay: .25s;
}
.search-bar-enter-active, .search-bar-leave-active {
  transition: width .25s ease;
}
@screen md {
  .main-header .search-bar-enter-active, .main-header .search-bar-leave-active {
    transition-delay: .15s;
  }
}
.search-bar-enter, .search-bar-leave-to {
  width: 0px;
}
input::placeholder {
  @apply font-light ;
  // color: config('colors.grey')
}
</style>
