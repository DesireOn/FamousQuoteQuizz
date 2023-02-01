<template>
  <view-mode-component :mode="mode"/>
</template>

<script>
import ViewModeComponent from '../components/viewMode.vue'

export default {
  name: 'Index',
  components: {
    ViewModeComponent
  },
  data() {
    return {
      mode: 'binary'
    };
  },
};
</script>