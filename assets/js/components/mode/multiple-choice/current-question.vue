<template>
  <question-description :visitor="visitor"/>
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
  <submit @change-status-state="saveHistory" />
</template>

<script>
import questionDescription from "../question-description.vue";
import submit from "../submit.vue";

export default {
  name: 'currentQuestion',
  components: {
    questionDescription, submit
  },
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  emits: ['change-status-state'],
  data() {
    return {
      selectedAnswer: null,
    }
  },
  methods: {
    saveHistory() {
      this.$emit('change-status-state', 'multiple-choice', this.selectedAnswer);
    },
  }
}
</script>