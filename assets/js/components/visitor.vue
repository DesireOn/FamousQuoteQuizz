<template>
<!--  <view-mode-component :visitor="this.visitor" :is-binary-mode="this.isBinaryMode"/>-->
</template>

<script>
import axios from 'axios';

export default {
  name: 'visitor',
  components: {
    // ViewModeComponent
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