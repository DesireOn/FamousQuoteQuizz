<template>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'binary'">
    <binary :visitor="visitor" @change-view="changeView" @generate-next-question="generateNextQuestion"/>
  </div>
  <div v-if="visitor && visitor.settings && visitor.settings.view_mode === 'multiple_choice'">
    <multiple-choice
        :visitor="visitor"
        :show-success="showSuccess"
        :show-error="showError"
        :show-scoring="showScoring"
        :scoring="scoring"
        @change-view="changeView"
        @generate-next-question="generateNextQuestion"
        @change-status-state="changeStatusState"
        @start-again="startAgain"
    />
  </div>
</template>

<script>

import MultipleChoice from "./multiple-choice/index.vue";
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
      scoring: {},
      showScoring: false
    }
  },
  methods: {
    changeView(mode) {
      this.visitor.settings.view_mode = mode;
    },
    async generateNextQuestion() {
      try {
        const getResponse = await axios.get(this.visitor['@id']+'/next-question');
        if (getResponse.data.nextQuestion === undefined) { // No more questions left for this visitor
          const getResponse = await axios.get('/api/scorings/'+this.visitor.session);
          this.scoring = getResponse.data;
          this.showScoring = true;
        } else {
          this.visitor.nextQuestion = getResponse.data.nextQuestion;
        }
        this.showSuccess = false;
        this.showError = false;
      } catch (error) {
      }
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