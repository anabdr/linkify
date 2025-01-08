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
  background-color:rgb(3 169 244 / 21%);

  .container {
    margin-top: 40px;
    max-width: 85vw;
    display: flex;
    align-items: center;
    height:auto;
    justify-content: center;
    

    @media(max-width: 700px){
      width: 98vw;
      height: 98vh;
      padding: 0;
    }
    

    form {
    display: flex;
    flex-flow: column;
    margin: 40px 0px 70px 0;
    @media(max-width: 700px){
      margin: 40px 0px 20px 0;
    }
    
      input {
        padding: 15px 20px;
        font-size: 1rem;
        border: 1px solid #cecece;
        border-radius: 4px;
        margin-bottom: 10px;

        &[type=submit] {
          cursor: pointer;
          font-size: large;
          font-weight: 700;
          border-radius: 20px;
        }
      }
    }
    .error[data-v-026a7a08] + form{
      margin-top: 0;
      input[type=submit]{
        margin:0;
      }
    }
  }
  
}
</style>
