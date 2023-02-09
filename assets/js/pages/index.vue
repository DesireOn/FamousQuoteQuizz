<template>
  <v-app :theme="theme">
    <v-app-bar>
      <v-spacer>
        <v-btn color="primary" @click="changePage('settings')">Settings</v-btn>
      </v-spacer>
    </v-app-bar>

    <v-main>
      <v-container>
        <mode v-if="!showSettings" :visitor="this.visitor" />
        <settings v-if="showSettings" :visitor="this.visitor" @hide-settings="hideSettings" />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Visitor from "../components/visitor.vue";
import settings from "./settings/index.vue";
import axios from "axios";
import mode from "../components/mode/index.vue";

export default {
  name: 'Index',
  components: {
    Visitor, settings, mode
  },
  data() {
    return {
      visitor: {},
      showSettings: false
    }
  },
  methods: {
    changePage(pageName) {
      if (pageName === 'settings') {
        this.showSettings = true;
      }
    },
    async hideSettings() {
      this.showSettings = false;
      const getResponse = await axios.get(this.visitor['@id']);
      this.visitor = await getResponse.data;
    }
  },
  async mounted() {
    if (localStorage.session_id) {
      const response = await axios.get('/api/visitors/'+localStorage.session_id);
      this.visitor = response.data;
    } else {
      const response = await axios.post('/api/visitors', {});
      if (response.status === 201) {
        localStorage.session_id = response.data.session;
        this.visitor = response.data;
      }
    }
  },
};
</script>

<script setup>
import { ref } from 'vue'

const theme = ref('light')
</script>