<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="plain" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="outlined" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
  <div v-if="!showSuccess && !showError && !showScoring">
    <question-description :visitor="visitor" />
    <current-question :visitor="visitor" @answer-picked="answerPicked" />
  </div>

  <next-question-component
      :show-error="showError"
      :show-success="showSuccess"
      @generate-next-question="generateNextQuestion"
  />

  <div v-if="showScoring">
    <stats :scoring="scoring" />
    <start-again @start-again="startAgain" />
  </div>
</template>

<script>
import questionDescription from "../question-description.vue";
import currentQuestion from "./current-question.vue";
import nextQuestionComponent from "../next-question.vue";
import stats from "../stats.vue";
import startAgain from "../startAgain.vue";

export default {
  name: 'binary',
  components: {
    questionDescription, currentQuestion, nextQuestionComponent, startAgain, stats
  },
  props: {
    visitor: {
      type: Object,
      required: true
    },
    showSuccess: {
      type: Boolean,
      required: true
    },
    showError: {
      type: Boolean,
      required: true
    },
    showScoring: {
      type: Boolean,
      required: true
    },
    scoring: {
      type: Object,
      required: true
    }
  },
  emits: ['change-view', 'generate-next-question'],
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    answerPicked(selectedAnswer, binaryValue) {
      this.$emit('change-status-state', 'binary', selectedAnswer, binaryValue);
    },
    generateNextQuestion() {
      this.$emit('generate-next-question');
    },
    startAgain() {
      this.$emit('start-again');
    }
  }
}
</script>