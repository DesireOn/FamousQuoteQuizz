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
    <v-card class="mx-auto mt-3" color="green">
      <v-card-text>Congrats!</v-card-text>
      <v-card-text>You have successfully completed our quiz!</v-card-text>
      <v-card-text>Number of correct answers: {{ scoring.numberOfCorrectAnswers }}</v-card-text>
      <v-card-text>Number of wrong answers: {{ scoring.numberOfWrongAnswers }}</v-card-text>
      <v-card-text>Your success rate is: {{ scoring.successRate }}%</v-card-text>
    </v-card>

    <div class="d-flex justify-space-around">
      <v-btn color="primary" @click="startAgain" class="mt-3">
        Start Again
      </v-btn>
    </div>
  </div>
</template>

<script>
import questionDescription from "../question-description.vue";
import currentQuestion from "./current-question.vue";
import nextQuestionComponent from "../next-question.vue";

export default {
  name: 'binary',
  components: { questionDescription, currentQuestion, nextQuestionComponent },
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