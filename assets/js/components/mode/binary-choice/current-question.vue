<template>
  <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
    <v-card-text>
      {{ selectedSuggestion.answer.name }}?
    </v-card-text>
  </div>
  <div class="d-flex justify-space-around align-center flex-column flex-md-row fill-height">
    <v-btn color="green" @click="answerPicked('y')">
      Yes
    </v-btn>
    <v-btn rounded="lg" color="red" @click="answerPicked('n')">
      No
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'suggestion',
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  setup(props) {
    const suggestions = props.visitor.nextQuestion.questionSuggestions;
    const selectedSuggestion = suggestions[Math.floor(Math.random() * suggestions.length)];

    return {
      selectedSuggestion
    }
  },
  emits: ['answer-picked'],
  methods: {
    answerPicked(binaryValue) {
      this.$emit('answer-picked', this.selectedSuggestion.answer['@id'], binaryValue);
    }
  }
}
</script>