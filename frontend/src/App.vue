<template>
  <div id="app">
   
    <HeaderNav v-if="token"/>

    <div class="container">
      <router-view />
    </div>
    
  </div>
</template>

<script setup>
import { computed } from 'vue'
import HeaderNav from '@/components/HeaderNav'
import { useStore } from 'vuex'

const store = useStore()

const token = computed(() => store.state.token)
</script>

<style lang="scss">
html, body {
  margin: 0;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;

  .container {
    margin-top: 60px;
    max-width: 900px;
    margin: 0 auto;

    form {
    display: flex;
    flex-flow: column;
    margin: 40px 0px;
    
      input {
        padding: 15px 20px;
        font-size: 1rem;
        border: 1px solid #cecece;
        border-radius: 4px;
        margin-bottom: 10px;

        &[type=submit] {
          cursor: pointer;
          background-color: #beebbe;
          color: #2c782c;
          font-weight: 700;
        }
      }
    }
  }
  
}
</style>
