<template>
  <div class="register">

    <div class="logo">
      <img src="../assets/Linkify_logo_no_background-removebg-preview.png">
    </div>

    <h3>Crear Usuario</h3>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>

    <form @submit.prevent="register()">
      <input 
        v-model="email"
        type="email" 
        placeholder="Email" />

      <input 
        v-model="name"
        type="text" 
        placeholder="Name" />

      <input 
        v-model="password"
        type="password"                 
        placeholder="Password" />

      <input
        type="submit"
        value="Crear Usuario" />
    </form>

    <p>¿ya tienes una cuenta? <router-link to="login">Inicia sesión!</router-link></p>

  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useRegister } from '@/composables/useRegister.js'
  import { useRouter } from 'vue-router'
  import Spinner from '@/components/Spinner'
  import Error from '@/components/Error'

  const router = useRouter()

  let loading = ref(false)
  let error = ref(null)

  let email = ref(null)
  let name = ref(null)
  let password = ref(null)

  const register = async () => {
    
    error.value = null

    try {

      if(!email.value || !password.value || !name.value) throw "Rellena todos los campos"

      if(password.value.length < 8) throw "La contraseña debe tener al menos 8 caracteres"
      
      loading.value = true

      let resp = await useRegister(email.value, password.value, name.value)

      router.push({name: 'Login'})

    } catch (e) {

      error.value = e

    } finally {

      loading.value = false
    }
  }
</script>

<style lang="scss">
.register{
    background-color: white;
    width: 40vw;
    height: 80vh;
    padding: 60px;
    border-radius: 20px;

    .logo{
      margin-bottom: 20px;
      img{
        width: 50%;        
      }
    }
}
</style>