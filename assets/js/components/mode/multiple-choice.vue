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

  <div v-if="showSuccess || showError">
    <multiple-choice-success-component v-if="showSuccess"/>
    <multiple-choice-error-component v-if="showError"/>

    <div class="d-flex justify-space-around">
      <v-btn color="primary" @click="generateNextQuestion" class="mt-3">
        Next Question
      </v-btn>
    </div>
  </div>

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

import axios from "axios";
import MultipleChoiceSuccessComponent from "./multiple-choice-success.vue";
import MultipleChoiceErrorComponent from "./multiple-choice-error.vue";

export default {
  name: 'multipleChoice',
  components: {
    MultipleChoiceSuccessComponent, MultipleChoiceErrorComponent
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
  },
  emits: ['change-view', 'generate-next-question', 'change-status-state'],
  data() {
    return {
      selectedAnswer: null,
      scoring: {},
      showScoring: false
    }
  },
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    saveHistory() {
      this.$emit('change-status-state', 'multiple-choice', this.selectedAnswer)
    },
    async generateNextQuestion() {
      try {
        const getResponse = await axios.get(this.visitor['@id']+'/next-question');
        if (getResponse.data.nextQuestion === undefined) { // No more questions left for this visitor
          const getResponse = await axios.get('/api/scorings/'+this.visitor.session);
          this.scoring = getResponse.data;
          this.showScoring = true;
        } else {
          this.$emit('generate-next-question', getResponse.data.nextQuestion);
        }
        this.showSuccess = false;
        this.showError = false;
      } catch (error) {
        console.error(error);
      }
    },
    async startAgain() {
      const getResponse = await axios.get(this.visitor['@id']);
      let newVisitorObject = await getResponse.data;
      await newVisitorObject.visitorHistory.forEach(
        history => axios.delete(history)
      )
      await this.generateNextQuestion();
      this.showScoring = false;
      this.visitor = new newVisitorObject;
    }
  }
};
</script>