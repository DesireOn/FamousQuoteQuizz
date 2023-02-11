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
import settings from "./settings/index.vue";
import axios from "axios";
import mode from "../components/mode/index.vue";

export default {
  name: 'Index',
  components: {
    settings, mode
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
      const getResponse = await axios.get('/api/visitors/'+localStorage.session_id);
      this.visitor = getResponse.data;
    } else {
      const postResponse = await axios.post('/api/visitors', {});
      if (postResponse.status === 201) {
        localStorage.session_id = postResponse.data.session;
        const getResponse = await axios.get('/api/visitors/'+localStorage.session_id);
        this.visitor = getResponse.data;
      }
    }
  },
};
</script>

<script setup>
import { ref } from 'vue'

const theme = ref('light')
</script>