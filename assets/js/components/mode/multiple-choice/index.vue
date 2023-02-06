<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="outlined" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="plain" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
  <div v-if="!showSuccess && !showError && !showScoring">
    <div class="d-flex center mt-3">
      <v-card class="mx-auto" color="primary">
        <v-card-text>"{{ visitor.nextQuestion.name }}"</v-card-text>
      </v-card>
    </div>
    <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
      <v-radio-group v-model="selectedAnswer">
        <v-radio
            color="primary"
            v-for="option in visitor.nextQuestion.questionSuggestions"
            :key="option['@id']"
            :label="option.answer.name"
            :value="option.answer['@id']">
        </v-radio>
      </v-radio-group>
    </div>
    <div class="d-flex justify-space-around">
      <v-btn color="primary" @click="saveHistory">
        Submit
      </v-btn>
    </div>
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

import SuccessMessageComponent from "../success-message.vue";
import ErrorMessageComponent from "../error-message.vue";
import NextQuestionComponent from "../next-question.vue";

export default {
  name: 'multipleChoice',
  components: {
    SuccessMessageComponent, ErrorMessageComponent, NextQuestionComponent
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
  data() {
    return {
      selectedAnswer: null,
    }
  },
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    saveHistory() {
      this.$emit('change-status-state', 'multiple-choice', this.selectedAnswer);
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