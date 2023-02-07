<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="plain" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="outlined" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
  <question-description :visitor="visitor" />
  <suggestion :visitor="visitor" />
  <answer />
</template>

<script>
import questionDescription from "../question-description.vue";
import suggestion from "./suggestion.vue";
import answer from "./answer.vue";

export default {
  name: 'binary',
  components: { questionDescription, suggestion, answer },
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  emits: ['change-view', 'generate-next-question'],
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    }
  }
}
</script>