<template>
  <div v-if="showSuccess || showError">
    <success-message-component v-if="showSuccess"/>
    <error-message-component v-if="showError"/>

    <div class="d-flex justify-space-around">
      <v-btn color="primary" @click="generateNextQuestion" class="mt-3">
        Next Question
      </v-btn>
    </div>
  </div>
</template>

<script>
import SuccessMessageComponent from "./success-message.vue";
import ErrorMessageComponent from "./error-message.vue";

export default {
  name: 'nextQuestion',
  components: {
    SuccessMessageComponent, ErrorMessageComponent
  },
  props: {
    showSuccess: {
      type: Boolean,
      required: true
    },
    showError: {
      type: Boolean,
      required: true
    },
  },
  emits: ['generate-next-question'],
  methods: {
    generateNextQuestion() {
      this.$emit('generate-next-question');
    },
  }
}
</script>