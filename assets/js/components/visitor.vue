<template>
  <mode-component :visitor="this.visitor" />
</template>

<script>
import axios from 'axios';
import ModeComponent from './mode'

export default {
  name: 'visitor',
  components: {
    ModeComponent
  },
  data() {
    return {
      visitor: {},
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
  }
}
</script>