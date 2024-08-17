<template>
  <header>
    
    <div class="logo">
    Acortador
    </div>

    <nav>
        <ul>
            <li>
                <router-link to="/">Dashboard</router-link>
            </li>
        </ul> 

        <button>
            <router-link to="/link">Acortar enlace</router-link>
        </button>

        <div 
        class="user" 
        @click="logout()">  
            Cerrar sesión
        </div>              
    </nav>
    
  </header>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

const router = useRouter()
const store = useStore()

const logout = () => {

    store.dispatch('logout')

    router.push({name: 'Login'})
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
header {
    background-color: white;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
    display: flex;
    justify-content: space-between;
    align-items:center;
    padding: 15px 20px;
    nav {
        display: flex;
        align-items: center;
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
            li {
                a {
                    display: block;
                    padding: 10px 20px;
                    text-decoration: none;
                    font-size: 1rem;
                    color: #444444;
                }
            }
        }
        button {
            border: 0;
            background: none;
            margin: 0 15px;
            a {
                background-color: #55cb55;
                color: white;
                border-radius: 4px;
                padding: 15px 25px;
                border: 0px;
                text-decoration: none;
                font-size: 1rem;
            }
        }
        .user {
            cursor: pointer;
        }
    }
}
</style>