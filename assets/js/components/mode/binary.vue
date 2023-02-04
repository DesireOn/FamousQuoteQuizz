<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="outlined">
      Binary (Yes/No) Mode
    </v-btn>
    <v-btn variant="plain">
      Multiple choice Mode
    </v-btn>
  </div>
  <div class="d-flex center mt-3">
    <v-card class="mx-auto" color="purple">
      <v-card-text>"{{ visitor.nextQuestion.name }}"</v-card-text>
    </v-card>
  </div>

  <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
    <v-card-text>
      {{ selectedSuggestion.answer.name }}?
    </v-card-text>
  </div>

  <div class="d-flex justify-space-around align-center flex-column flex-md-row fill-height">
    <v-btn color="green">
      Yes
    </v-btn>
    <v-btn rounded="lg" color="red">
      No
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'binary',
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
  }
}
</script>