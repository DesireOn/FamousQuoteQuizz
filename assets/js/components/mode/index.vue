<template>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'binary'">
    <binary :visitor="visitor" @change-view="changeView" @generate-next-question="generateNextQuestion"/>
  </div>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'multiple_choice'">
    <multiple-choice
        :visitor="visitor"
        :show-success="showSuccess"
        :show-error="showError"
        @change-view="changeView"
        @generate-next-question="generateNextQuestion"
        @change-status-state="changeStatusState"
    />
  </div>
</template>

<script>

import MultipleChoice from "./multiple-choice.vue";
import Binary from "./binary.vue";
import axios from "axios";

export default {
  name: 'viewMode',
  components: {
    MultipleChoice, Binary
  },
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      showSuccess: false,
      showError: false,
    }
  },
  methods: {
    changeView(mode) {
      this.visitor.settings.view_mode = mode;
    },
    generateNextQuestion(nextQuestion) {
      this.visitor.nextQuestion = nextQuestion;
    },
    async changeStatusState(mode, selectedAnswer) {
      if (mode === 'multiple-choice') {
        try {
          const postResponse = await axios.post('/api/visitor_histories/multiple-choice', {
            'visitor': this.visitor['@id'],
            'question': this.visitor.nextQuestion['@id'],
            'answer': selectedAnswer
          });

          const getResponse = await axios.get(postResponse.data['@id']);
          if (getResponse.data.correct) {
            this.showSuccess = true;
          } else {
            this.showError = true;
          }
        } catch (error) {
        }
      } else {
        const postResponse = {};
      }
    }
  }
};
</script>