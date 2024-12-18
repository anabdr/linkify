<template>
  <div class="dashboard">

    <h1>Tus Links</h1>

    <Spinner v-if="loading"/>

    <Error v-else-if="error" :error="error"/>
    

    <template  v-else-if="series[0].data.length > 0">
      <apexchart 
    
      type="bar" 
      height="350"
      :options="chartOptions" 
      :series="series" />

      <ul 
      v-if="links" 
      class="links">
        <li 
        v-for="link in links" 
        :key="link.id">
          <p>{{link.url}}</p>
          <span @click="openLink(link)">{{`${apiDomain}/${link.code}`}}</span>
          <div class="icons">
            <!--copy-->            
            <svg @click="copyToClipboard(link)" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21 8C21 6.34315 19.6569 5 18 5H10C8.34315 5 7 6.34315 7 8V20C7 21.6569 8.34315 23 10 23H18C19.6569 23 21 21.6569 21 20V8ZM19 8C19 7.44772 18.5523 7 18 7H10C9.44772 7 9 7.44772 9 8V20C9 20.5523 9.44772 21 10 21H18C18.5523 21 19 20.5523 19 20V8Z" fill="#0F0F0F"></path> <path d="M6 3H16C16.5523 3 17 2.55228 17 2C17 1.44772 16.5523 1 16 1H6C4.34315 1 3 2.34315 3 4V18C3 18.5523 3.44772 19 4 19C4.55228 19 5 18.5523 5 18V4C5 3.44772 5.44772 3 6 3Z" fill="#0F0F0F"></path> </g></svg>
            <!--delete-->
            <svg @click="deleteLink(link,store)" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000000" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"></path></g></svg>
          </div>          
        </li>
        <Modal v-if="copySuccess" :copySuccess="copySuccess"/>
      </ul>
    </template>
    <div v-else>
      <img width="200px" src="@/assets/undraw_taken_re_yn20.svg">
      <p>Vaya... parece que aún no tienes ningún enlace</p>
      <router-link to="Link">Crea tu primer enlace ahora</router-link>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { useLinkCounter } from '@/composables/useLinkCounter.js'
import { useStore } from 'vuex'
import Error from '@/components/Error'
import Spinner from '@/components/Spinner'
import Modal from '@/components/Modal'
import { useFetchWithAuth } from '@/composables/useFetchWithAuth'
import { useDeleteLink } from '@/composables/useDeleteLink'
import { useRouter } from 'vue-router'

const apiDomain = process.env.VUE_APP_DOMAIN

const store = useStore()
const loading = ref(false)
const error = ref(null)
const copySuccess = ref('')
const router = useRouter()

const chartOptions = reactive({
  chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      borderRadiusApplication: 'end',
      horizontal: true,
    }
  },
  dataLabels: {
    enabled: false
  },
  xaxis: {
    categories: [],
  }
})

const series = reactive([{
  data: []
}])

let links = ref(null)

const fetchCounter = async () => {

  error.value = null

  try {

    loading.value = true

    const counter = await useLinkCounter(store)

    links.value = counter

    chartOptions.xaxis.categories = counter.map(m => m.url)

    series[0].data = counter.map(m => Number(m.count))

  } catch (e) {

    error.value = e

  } finally {

    loading.value = false
  }
}

const openLink = (link) => {

  window.open(`${apiDomain}/${link.code}`, '_target')
}

const copyToClipboard = (link) => {
  try{
    navigator.clipboard.writeText(apiDomain+"/"+link.code);
    cleanModal("¡Enlace copiado!");
    
  }catch (err){
    console.log('error: ' + err);
  }
}

const deleteLink = async (url,store) => {

  try{
    
    let resp = await useDeleteLink(url, store);
    cleanModal('¡Enlace eliminado');
    await fetchCounter();

  }catch (err){
    console.log('error: ' + err);
  }
}

const cleanModal = (message) => {

  //add message for modal
  copySuccess.value = message;

    //clean the modal after 2 seconds
    setTimeout(() => {
      copySuccess.value = ''; 
    }, 2000);

}

onMounted(() => {
  fetchCounter()
})

</script>

<style lang="scss">
div.dashboard{
  background-color: white;
  padding: 70px;
  border-radius: 20px;
  ul.links {
    margin: 20px 0 0 0;
    padding: 0;
    list-style: none;

    li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #eeeeee;
      margin-bottom: 5px;
      border-radius: 4px;
      padding: 5px 20px;

      p{
        width: 16vw;
        text-align: left;
      }

      span {
        background-color: white;
        cursor: pointer;
        border: 2px dashed #ffa7a7;
        padding: 8px 30px;
        width: 65%;
        margin-left: 30px;
      }
      .icons{
        max-width: 7%;
        svg{
          width: 33%;
          height: 30%;
          padding: 0;
          margin: 0 0 0 10px;
        }
        svg:hover{
          cursor: pointer;
        }
        
      }
    }
  }
}
</style>
