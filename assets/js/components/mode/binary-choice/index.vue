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
  <current-question :visitor="visitor" @answer-picked="answerPicked" />
</template>

<script>
import questionDescription from "../question-description.vue";
import currentQuestion from "./current-question.vue";

export default {
  name: 'binary',
  components: { questionDescription, currentQuestion },
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
    },
    answerPicked(selectedAnswer, binaryValue) {
      this.$emit('change-status-state', 'binary', selectedAnswer, binaryValue);
    }
  }
}
</script>