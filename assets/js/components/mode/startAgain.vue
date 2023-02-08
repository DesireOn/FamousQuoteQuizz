<template>
  <div class="d-flex justify-space-around">
    <v-btn color="primary" @click="startAgain" class="mt-3">
      Start Again
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'startAgain',
  emits: ['start-again'],
  methods: {
    startAgain() {
      this.$emit('start-again');
    }
  }
}
</script>