<template>
  <header>
    
    <div class="logo" @click="goTo('Home')">
        <img src="../assets/Linkify_logo_no_background-removebg-preview.png">
    </div>

    <nav>
        <ul :class="{ active: isMenuOpen }">
            <li>
                <router-link to="/">Dashboard</router-link>
            </li>
        </ul> 

        <button :class="{ active: isMenuOpen }">
            <router-link to="/link" class="btn btn-primary">Acortar enlace</router-link>
        </button>

        <div 
        class="user" 
        @click="logout()">  
            Cerrar sesión
        </div>              
    </nav>

    <div class="menu-icon" @click="toggleMenu">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div 
        class="menu-open"
        v-if="isMenuOpen">
        <div class="menu-close" @click="closeMenu()">✖</div>
        <ul>

            <li>
                <div @click="goTo('Home')">Dashboard</div>
            </li>
            <li>
                <div @click="goTo('Link')">Acortar enlace</div>
            </li>
            <li>
                <div @click="logout()">Cerrar sesión</div>
            </li>
        </ul> 

    </div>
    
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

const router = useRouter()
const store = useStore()
const isMenuOpen = ref(false)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

const closeMenu = () => {    
    isMenuOpen.value = false
}

const logout = () => {

    store.dispatch('logout')

    router.push({name: 'Login'})
}

const goTo = (route) => {
    isMenuOpen.value = false;
    router.push({name: route})
}
</script>


<style scoped lang="scss">
header {
    background-color: white;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 3px 20px;
    position: relative;

    .logo{
        img{
            height:90px;
        }
    }

    .menu-icon {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 20px;
        cursor: pointer;

        span {
        display: block;
        height: 3px;
        background-color: #444;
        border-radius: 2px;
        transition: all 0.3s ease;
        }
    }
    .menu-open {    
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        margin: 0;
        z-index: 9;
        background-color: white;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        .menu-close{
            color: black;
            position: fixed;
            top:20px;
            right: 20px;
            font-size: 35px;

        }

        ul{
            li, a{
                font-size: 25px;
                text-decoration: none;
                color: green;
                list-style: none;
                padding: 25px;
                cursor: pointer;
            }
            
        }
    }    

    nav {
        display: flex;
        align-items: center;

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;

            li > a {                
                display: block;
                padding: 10px 20px;
                text-decoration: none;
                font-size: 1rem;
                color: #444444;                
            }
        }

        button {
            border: 0;
            background: none;
            margin: 0 15px;

            a {
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

    
    @media (max-width: 768px) {
        .menu-icon {
            display: flex;
        }

        nav {
            display: block;
            width: 100%;
            position: absolute;
            top: 60px;
            left: 0;
            background-color: white;
            transition: max-height 0.3s ease;
            overflow: hidden;
            max-height: 0;

            ul {
                flex-direction: column;
                align-items: flex-start;

                li > a {                
                    padding: 10px 15px;                
                }
            }

            button {
                margin: 10px 0;

                a {
                    padding: 10px 20px;
                    display: block;
                    width: 100%;
                }
            }

            &.active {
                max-height: 300px;
            }
        }
    }

    
    @media (min-width: 769px) {

        .menu-icon, .menu-open {
            display: none;
        }
    }
}
</style>