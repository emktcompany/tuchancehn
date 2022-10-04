<template>
  <div id="app">
    <ckeditor @input="onInput" :editor="editor" v-model="html" :config="config"></ckeditor>
  </div>
</template>

<script>
  import * as CKEditor from '@ckeditor/ckeditor5-vue';
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  var ckeditor = CKEditor.component;

  export default {
    props: {
      value: {
        type: String,
        default: ''
      }
    },
    components: {
      ckeditor
    },
    name: 'wysiwyg-editor',
    data() {
      return {
        editor: ClassicEditor,
        html: '',
        config: {
          // The configuration of the editor.
        }
      };
    },
    watch: {
      value() {
        this.onModelChanged();
      }
    },
    created() {
      this.onModelChanged();
    },
    methods: {
      onModelChanged() {
        this.html = this.value || '';
      },
      onInput() {
        this.$emit('input', this.html);
      }
    },
    $_veeValidate: {
      value() {
        console.log('ok')
        return this.html;
      }
    }
  }
</script>
