<template>
  <div class="d-flex justify-space-around">
    <v-btn variant="outlined" @click="changeView('multiple_choice')">
      Multiple choice Mode
    </v-btn>
    <v-btn variant="plain" @click="changeView('binary')">
      Binary (Yes/No) Mode
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'chooseMode',
  emits: ['change-view'],
  methods: {
    changeView(mode) {
      this.$emit('change-view', mode);
    },
  }
}
</script>