<template>
  <div class="login">

    <h1>Acortar enlace</h1>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>

    <form @submit.prevent="add()">

      <input 
        v-model="url"
        type="text"
        placeholder="www.tu_pagina.com" />

      <input 
        type="submit" 
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
import Error from '@/components/Error'
import Spinner from '@/components/Spinner'

const apiDomain = process.env.VUE_APP_DOMAIN

const store = useStore()
const loading = ref(false)
const error = ref(null)
let code = ref(null)
let url = ref(null)

const add = async () => {

  error.value = null

  try {

    if (!url.value) throw "Rellena todos los campos" 

    useUrlValidation(url.value)

    loading.value = true

    let resp = await useAddLink(url.value, store)

    code.value = resp

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
</style>