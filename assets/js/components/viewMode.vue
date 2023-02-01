<template>
  <v-btn
      :variant="isBinaryMode ? 'outlined' : 'plain'"
      @:click="toggleMode('binary')"
  >
    Binary
  </v-btn>
  <v-btn
      :variant="!isBinaryMode ? 'outlined' : 'plain'"
      @:click="toggleMode('multiple_choice')"
  >
    Multi choice
  </v-btn>
</template>

<script>
export default {
  name: 'viewMode',
  props: {
    mode: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      isBinaryMode: this.mode === 'binary'
    }
  },
  methods: {
    toggleMode(mode) {
      this.isBinaryMode = mode === 'binary';
    }
  }
};
</script>