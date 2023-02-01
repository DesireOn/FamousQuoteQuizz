<template>
  {{ mode }}
</template>

<script>
export default {
  name: 'viewMode',
  props: {
    mode: {
      type: String,
      required: true
    }
  }
};
</script>