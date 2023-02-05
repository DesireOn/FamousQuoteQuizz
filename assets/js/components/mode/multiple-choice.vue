<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="outlined" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="plain" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
  <div class="d-flex center mt-3">
    <v-card class="mx-auto" color="primary">
      <v-card-text>"{{ visitor.nextQuestion.name }}"</v-card-text>
    </v-card>
  </div>
  <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
    <v-radio-group v-model="selectedAnswer">
      <v-radio
          color="primary"
          v-for="option in options"
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
</template>

<script>

import axios from "axios";

export default {
  name: 'multipleChoice',
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  emits: ['change-view'],
  data() {
    return {
      selectedAnswer: null,
      options: this.visitor.nextQuestion.questionSuggestions
    }
  },
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
    async saveHistory() {
      try {
        const response = await axios.post('/api/visitor_histories', {
          'visitor': this.visitor['@id'],
          'question': this.visitor.nextQuestion['@id'],
          'answer': this.selectedAnswer
        });
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>