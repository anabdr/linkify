<template>
  <div class="linkContainer">

    <h1>Acortar enlace</h1>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>

    <form @submit.prevent="add()">

      <input 
        v-model="url"
        type="text"
        placeholder="www.tu_pagina.com" 
        @input="validateUrl"/>
        <p v-if="validateUrl" style="color: red">{{urlError}}</p>

      <input 
        type="submit" 
        class="btn btn-primary"
        value="Crear Link" />
    </form>

    <div 
    v-if="code" 
    class="link"
    @click="openLink(`${apiDomain}/${code}`)">
      <p>{{`${apiDomain}/${code}`}}</p>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useAddLink } from '@/composables/useAddLink.js'
import { useUrlValidation } from '@/composables/useUrlValidation.js'
import { useRouter } from 'vue-router'
import Error from '@/components/Error'
import Spinner from '@/components/Spinner'

const apiDomain = process.env.VUE_APP_DOMAIN

const store = useStore()
const router = useRouter()
const loading = ref(false)
const error = ref(null)
let code = ref(null)
let url = ref(null)
let urlError = ref('')

const validateUrl = () => {
  const urlRegex = /^(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}([\/?][a-zA-Z0-9-_.~&=]*)*$/;
  
  if(!url.value){
    urlError.value = 'Es obligatorio añadir una url'
  }else if(!urlRegex.test(url.value)){
    urlError.value = "La url no es valida"
  }else{
    urlError.value = ""
  }
}

const add = async () => {

  error.value = null

  try {
    if( !store.state.token) router.push({name: 'Login'})
    if (!url.value) throw "Rellena todos los campos" 

    useUrlValidation(url.value)

    loading.value = true

    let resp = await useAddLink(url.value, store)

    code.value = resp

    url.value = ''

  } catch (e) {

    error.value = e

  } finally {

    loading.value = false
  }
}

const openLink = (link) => {

  window.open(link, '_target')
}

</script>

<style lang="scss">
.link {
  border: 2px dashed #4bd453;
  border-radius: 10px;
  background-color: #ebffe8;
  cursor: pointer;
}
.linkContainer {
    margin: 1rem;
    background-color: white;
    width: 40vw;
    height: 50vh;
    padding: 60px;
    border-radius: 20px;
    form{
      input{
        margin: 50px 0 0 0;

        &[type=submit] {
          margin-top: 50px;
        }
      }

    }
}
</style>