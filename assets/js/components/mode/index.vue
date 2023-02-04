<template>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'binary'">
    <binary :visitor="visitor"/>
  </div>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'multiple_choice'">
    <multiple-choice :visitor="visitor"/>
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
};
</script>