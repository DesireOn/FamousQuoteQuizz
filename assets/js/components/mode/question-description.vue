<template>
  <div class="d-flex center mt-3">
    <v-card class="mx-auto" color="primary">
      <v-card-text>"{{ visitor.nextQuestion.name }}"</v-card-text>
    </v-card>
  </div>
</template>

<script>
export default
{
  name: 'questionDescription',
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
}
</script>