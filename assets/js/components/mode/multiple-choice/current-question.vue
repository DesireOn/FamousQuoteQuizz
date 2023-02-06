<template>
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
</template>

<script>
export default {
  name: 'currentQuestion',
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