<template>
  <div class="login">

    <h1>Login</h1>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>

    <form @submit.prevent="login()">

      <input 
        v-model="email"
        type="text" 
        placeholder="Email" />

      <input 
        v-model="password"
        type="password" 
        placeholder="Password" />

      <input 
        type="submit" 
        value="Iniciar sesión" />
     </form>

     <p>¿Aún no tienes cuenta? <router-link to="register">Regístrate!</router-link></p>
     

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useLogin } from '@/composables/useLogin.js'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'
import Spinner from '@/components/Spinner'
import Error from '@/components/Error'

const router = useRouter()
const store = useStore()

let loading = ref(false)
let error = ref(null)

let email = ref(null)
let password = ref(null)

const login = async () => {

  error.value = null

  try {

    if (!email.value || !password.value) throw "Rellena todos los campos" 

    loading.value = true

    let resp = await useLogin(email.value, password.value)
    console.log('resp login', resp)
    localStorage.setItem('token', resp.access_token)

    store.dispatch('setSession')

    router.push({name: 'Home'})

  } catch (e) {

    error.value = e

  } finally {

    loading.value = false
  }
}

</script>