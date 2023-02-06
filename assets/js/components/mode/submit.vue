<template>
  <div class="d-flex justify-space-around">
    <v-btn color="primary" @click="saveHistory">
      Submit
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'submit',
  emits: ['change-status-state'],
  methods: {
    saveHistory() {
      this.$emit('change-status-state');
    },
  }
}
</script>