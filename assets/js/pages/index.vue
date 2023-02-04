<template>
  <v-app :theme="theme">
    <v-app-bar>
      <v-spacer></v-spacer>
    </v-app-bar>

    <v-main>
      <v-container>
        <visitor></visitor>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Visitor from "../components/visitor.vue";

export default {
  name: 'Index',
  components: {
    Visitor,
  },
};
</script>

<script setup>
import { ref } from 'vue'

const theme = ref('light')
</script>