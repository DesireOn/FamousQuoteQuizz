<template>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'binary'">
    <v-btn variant="outlined">
      Binary (Yes/No)
    </v-btn>
    <v-btn variant="plain">
      Multiple choice
    </v-btn>
  </div>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'multiple_choice'">
    <multiple-choice :visitor="visitor"/>
  </div>
</template>

<script>

import MultipleChoice from "./multiple-choice.vue";

export default {
  name: 'viewMode',
  components: {MultipleChoice},
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
};
</script>