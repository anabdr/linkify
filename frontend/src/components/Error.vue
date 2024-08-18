<template>
  <div class="error">
    <p>{{error}}</p>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  error: {
    type: String,
    required: true
  }
})

const error = props.error
</script>


<style scoped lang="scss">
.error {
  background-color: #ffcdcd;
  color: #ff4e4e;
  font-weight: 600;
  padding: 20px;
  border-radius: 4px;

  p {
    margin: 0;
  }
}
</style>
