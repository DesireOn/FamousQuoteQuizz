<template>
  <choose-mode @change-view="changeView"/>

  <div v-if="!showSuccess && !showError && !showScoring">
    <current-question :visitor="visitor" @change-status-state="saveHistory"/>
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

import SuccessMessageComponent from "../success-message.vue";
import ErrorMessageComponent from "../error-message.vue";
import NextQuestionComponent from "../next-question.vue";
import ChooseMode from "./choose-mode.vue";
import currentQuestion from "./current-question.vue";
import stats from "../stats.vue";
import startAgain from "../startAgain.vue";
export default {
  name: 'multipleChoice',
  components: {
    ChooseMode,
    SuccessMessageComponent, ErrorMessageComponent, NextQuestionComponent, currentQuestion, startAgain, stats
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
  emits: ['change-view', 'generate-next-question', 'change-status-state', 'start-again'],
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    saveHistory(mode, selectedAnswer) {
      this.$emit('change-status-state', 'multiple-choice', selectedAnswer);
    },
    generateNextQuestion() {
      this.$emit('generate-next-question');
    },
    startAgain() {
      this.$emit('start-again');
    }
  }
};
</script>