<template>
  <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
    <v-card-text>
      {{ selectedSuggestion.answer.name }}?
    </v-card-text>
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
}
</script>