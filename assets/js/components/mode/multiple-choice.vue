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
    <v-radio-group>
      <v-radio
          color="primary"
          v-for="questionSuggestion in visitor.nextQuestion.questionSuggestions"
          :key="questionSuggestion['@id']"
          :label="questionSuggestion.answer.name"
          :value="questionSuggestion['@id']">
      </v-radio>
    </v-radio-group>
  </div>
  <div class="d-flex justify-space-around">
    <v-btn color="primary">
      Submit
    </v-btn>
  </div>
</template>

<script>

export default {
  name: 'multipleChoice',
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  emits: ['change-view'],
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    }
  }
};
</script>