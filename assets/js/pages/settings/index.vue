<template>
  <div class="d-flex flex-column align-center justify-center mx-auto mt-3">
    <div v-if="showStartAgain">
      <v-card class="mx-auto mb-3" color="green">
        <v-card-text>Successfully updated settings.</v-card-text>
      </v-card>
      <v-btn color="primary" @click="startAgain">Start again</v-btn>
    </div>
    <div v-if="!showStartAgain">
      <v-radio-group v-model="selectedAnswer">
        <v-radio label="Binary Mode" value="binary"></v-radio>
        <v-radio label="Multiple Choice Mode" value="multiple_choice"></v-radio>
      </v-radio-group>
      <v-btn color="primary" @click="submit(selectedAnswer)">Submit</v-btn>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: 'settings',
  data() {
    return {
      selectedAnswer: null,
      showStartAgain: false
    }
  },
  props: {
    visitor: {
      type: Object,
      required: true
    },
  },
  emits: ['hide-settings'],
  methods: {
    async submit() {
      await axios.put(this.visitor['@id'], {
        'settings': {
          'view_mode': this.selectedAnswer
        }
      });
      const getResponse = await axios.get(this.visitor['@id']);
      let newVisitor = await getResponse.data;
      await newVisitor.visitorHistory.forEach(
          history => axios.delete(history)
      );
      this.showStartAgain = true;
    },
    startAgain() {
      this.$emit('hide-settings');
    }
  }
}
</script>