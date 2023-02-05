<template>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'binary'">
    <binary :visitor="visitor" @change-view="changeView"/>
  </div>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'multiple_choice'">
    <multiple-choice :visitor="visitor" @change-view="changeView"/>
  </div>
</template>

<script>

import MultipleChoice from "./multiple-choice.vue";
import Binary from "./binary.vue";

export default {
  name: 'viewMode',
  components: {
    MultipleChoice, Binary
  },
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  methods: {
    changeView(mode) {
      this.visitor.settings.view_mode = mode;
    }
  }
};
</script>