<template>
  <v-card class="mx-auto mt-3" color="green">
    <v-card-text>Congrats!</v-card-text>
    <v-card-text>You have successfully completed our quiz!</v-card-text>
    <v-card-text>Number of correct answers: {{ scoring.numberOfCorrectAnswers }}</v-card-text>
    <v-card-text>Number of wrong answers: {{ scoring.numberOfWrongAnswers }}</v-card-text>
    <v-card-text>Your success rate is: {{ scoring.successRate }}%</v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'stats',
  props: {
    scoring: {
      type: Object,
      required: true
    }
  }
}
</script>