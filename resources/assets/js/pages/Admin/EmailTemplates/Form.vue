<template lang="html">
  <form @submit.prevent="submit" class="bg-grey-lighter p-4 md:p-12 max-w-xl mx-auto mb-12">
    <h2 class="font-dosis font-bold text-purple mb-4">Plantilla</h2>
    <form-field name="title" label="Título">
      <input type="text" name="title" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.title">
    </form-field>
    <form-field name="is_active" label="Publicado">
      <radio-group v-model="row.data.is_active" name="is_active" v-validate="{required: true}" :options="$yesNo" />
    </form-field>
    <div class="flex w-full">
      <div class="w-1/2 pr-2">
        <form-field name="event" label="Disparado para">
          <choice-input name="event" v-model="role" :options="roles" label-key="name" value-key="id" empty-text="Rol" />
        </form-field>
      </div>
      <div class="w-1/2 pl-2">
        <form-field name="event" label="Cuando">
          <choice-input name="event" v-model="row.data.event" :options="avialableEvents" label-key="name" value-key="event" empty-text="Evento" />
        </form-field>
      </div>
    </div>

    <h2 class="font-dosis font-bold text-purple mb-4 mt-6">Contenido</h2>
    <v-draggable :options="{draggable: '.list-item'}" v-model="row.data.content" class="rounded list-group">
      <div class="list-item bg-white flex hover:shadow cursor-move" v-for="(category, i) in row.data.content">
        <div class="flex items-center pl-3">
          <svg-icon src="~@svg/icons/solid/grip-lines.svg" class="fill-current w-4 h-4" />
        </div>
        <div class="flex-1 pl-3">
          <form-field :name="`content_${i}`" label="Texto">
            <input type="text" :name="`content_${i}`" class="form-field text-sm" v-model="row.data.content[i]">
          </form-field>
        </div>
        <div class="flex items-center px-3">
          <confirm-button @confirmed="removeLine(i)"/>
        </div>
      </div>
    </v-draggable>
    <div class="flex items-end">
      <form-field class="flex-1" name="content_text" label="Insertar línea">
        <input @keyUp="keyUp" type="text" name="content_text" class="form-field text-sm rounded-r-none border-r-0" v-model="content_text">
      </form-field>
      <div class="flex-none py-2">
        <button @click="addLine" type="button" class="leading-none px-4 py-2 bg-grey-light border-2 border-grey-light hover:border-grey-cyan rounded-r-xl">
          &nbsp;<svg-icon src="~@svg/icons/solid/plus.svg" class="fill-current w-4 h-4" />&nbsp;
        </button>
      </div>
    </div>

    <h2 class="font-dosis font-bold text-purple mb-4 mt-6">Call to action</h2>
    <div class="flex flex-col md:flex-row -mx-2">
      <div class="md:w-1/2 px-2">
        <form-field name="cta" label="Enlace">
          <input type="url" name="cta" v-validate="{required: !!row.data.cta_text}" class="form-field text-sm" v-model="row.data.cta">
        </form-field>
      </div>
      <div class="md:w-1/2 px-2">
        <form-field name="cta_text" label="Texto">
          <input type="text" name="cta_text" v-validate="{required: !!row.data.cta}" class="form-field text-sm" v-model="row.data.cta_text">
        </form-field>
      </div>
    </div>
    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Perioricidad</h2>
    <form-field class="w-full" name="days" label="Este correo se debe enviar cada cuantos días">
      <input type="number" name="days" v-validate="{required: true}" class="form-field text-sm" v-model="row.data.days">
    </form-field>

    <h2 class="font-dosis font-bold text-purple mb-4 mt-12">Imágenes</h2>
    <div class="flex flex-col lg:flex-row justify-center -mx-2">
      <div class="lg:w-1/3 px-2 mb-6 md:mb-0">
        <div class="text-center text-cyan font-dosis mb-2">Imagen de Banner</div>
        <image-cropper :ratio="3.6" v-model="row.data.banner_crop" :default="row.data.banner || null"/>
      </div>
      <div class="lg:w-1/3 px-2">
        <div class="text-center text-cyan font-dosis mb-2">Imagen de pie de página</div>
        <image-cropper :ratio="3.6" v-model="row.data.footer_crop" :default="row.data.footer || null"/>
      </div>
      <div class="lg:w-1/3 px-2">
        <div class="text-center text-cyan font-dosis mb-2">Imagen de patrocinadores</div>
        <image-cropper :ratio="3.6" v-model="row.data.sponsor_crop" :default="row.data.sponsor || null"/>
      </div>
    </div>
    <div class="flex justify-end mt-6">
      <notification-preview :row="row.data"></notification-preview>
      <div class="flex">
        <button type="submit" class="btn bg-teal text-white">Guardar cambios</button>
      </div>
    </div>
  </form>
</template>

<script>
import NotificationPreview from '@/components/admin/NotificationPreview.vue';
import FormPage from '@/components/admin/FormPage.vue';
import events from '@/data/events';
import each from 'lodash/each';
import filter from 'lodash/filter';
import find from 'lodash/find';

require('@img/email-closing.png');
require('@img/email-footer-logo.png');
require('@img/email-logo.png');
require('@img/email-sponsors.png');

export default {
  components: {
    NotificationPreview
  },
  extends: FormPage,
  data() {
    return {
      content_text: '',
      role: null,
      events
    };
  },
  watch: {
    'row.data.event'(value, old) {
      if (value) {
        var event = find(this.events, {event: value}) || {for: 'n/a'};
        var role  = find(this.roles, {id: event.for});

        if (role) {
          this.role = role.id;
        }
      }
    }
  },
  computed: {
    roles() {
      var roles = [];

      each(this.events, (event) => {
        if (!find(roles, {id: event.for})) {
          roles.push({
            id: event.for,
            name: event.for,
          });
        }
      });

      return roles;
    },
    avialableEvents() {
      return filter(this.events, {
        for: this.role
      });
    }
  },
  methods: {
    saved({data}) {
      this.$router.push({
        name: 'admin.email-templates.edit',
        params: {id: data.id}
      });
    },
    reset() {
      this.row = {
        data: {
          event: '',
          days: '',
          title: '',
          content: [],
          cta: null,
          cta_text: null,
          footer: null,
          banner: null,
          sponsor: null
        }
      };
    },
    keyUp($event) {
      console.log($event.keyCode)
    },
    addLine() {
      this.row.data.content.push(this.content_text);
      this.content_text = '';
    },
    removeLine(i) {
      this.row.data.content.splice(i, 1);
    }
  }
}
</script>
