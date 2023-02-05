<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="outlined" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="plain" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
  <div v-if="!showSuccess && !showError">
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
  },
  emits: ['change-view', 'generate-next-question'],
  data() {
    return {
      selectedAnswer: null,
      showSuccess: false,
      showError: false
    }
  },
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    async saveHistory() {
      try {
        const postResponse = await axios.post('/api/visitor_histories', {
          'visitor': this.visitor['@id'],
          'question': this.visitor.nextQuestion['@id'],
          'answer': this.selectedAnswer
        });

        const getResponse = await axios.get(postResponse.data['@id']);
        if (getResponse.data.correct) {
          this.showSuccess = true;
        } else {
          this.showError = true;
        }
      } catch (error) {
        console.error(error);
      }
    },
    async generateNextQuestion() {
      try {
        const getResponse = await axios.get(this.visitor['@id']+'/next-question');
        // this.visitor.nextQuestion = getResponse.data.nextQuestion;
        this.$emit('generate-next-question', getResponse.data.nextQuestion);
        this.showSuccess = false;
        this.showError = false;
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>