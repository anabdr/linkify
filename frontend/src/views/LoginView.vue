<template>
  <div class="login">

    <div class="logo">
      <img src="../assets/Linkify_logo_no_background-removebg-preview.png">
      <h4>Shorten your URL's in seconds</h4>
    </div>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>

    <form @submit.prevent="login()">

      <input 
        v-model="email"
        type="text" 
        placeholder="Email" 
        @input="validateEmail" 
        :class="{ valid: !emailError, invalid: emailError }"/>
      <p v-if="emailError" style="color: red;">{{ emailError }}</p>

      <input 
        v-model="password"
        type="password" 
        placeholder="Password" 
        @input="validatePassword"/>
      <p v-if="passwordError" style="color: red;">{{ passwordError }}</p>

      <input 
        type="submit" 
        class="btn btn-primary"
        value="Iniciar sesión" />
     </form>

     <p>¿Aún no tienes cuenta? <router-link to="register">Regístrate!</router-link></p>
     

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
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
let emailError = ref('')
let password = ref(null)
let passwordError = ref('')

const validateEmail = () => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

  if(!email.value){
    emailError.value = "El campo de correo es obligatorio";
  }else if(!email.value.includes('@')){
    emailError.value = "El correo debe contener un '@'";
  }else if(!emailRegex.test(email.value)){
    emailError.value = "El correo no es válido";
  }else{
    emailError.value = "";
  }
}

const validatePassword = () => {
  if(!password.value){
    passwordError.value = "El campo de Password es obligatorio";
  }else if(password.value.length < 8){
    passwordError.value = "La contraseña debe contener al menos 8 caracteres";
  }else{
    passwordError.value = "";
  }
}

const isFormValid = computed(() => {
  return !emailError.value && !passwordError.value && email.value && password.value
})

const login = async () => {

  error.value = null

  try {

    if (!email.value || !password.value) throw "Rellena todos los campos" 

    loading.value = true

    let resp = await useLogin(email.value, password.value)
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

<style lang="scss">

.login{
  width:40vw;
  height:80vh;
  background-color:white;
  padding:6%;
  border-radius: 20px;
   
  .logo{
    margin-bottom: 100px;
    img{
      width: 50%;
    }
  }
  //mobile
  @media(max-width: 700px){
    width:100vw;
    .logo{      
      h4{
        font-size: 1rem;
        margin-top: 20px;
      }
    }
  }

  form{
    input[type=submit]{
      margin-top: 25px;
    }
  }
}

</style>