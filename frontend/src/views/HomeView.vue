<template>
  <div>

    <h1>Dashboard</h1>

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
        </li>
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
import { useFetchWithAuth } from '@/composables/useFetchWithAuth'

const apiDomain = process.env.VUE_APP_DOMAIN

const store = useStore()
const loading = ref(false)
const error = ref(null)

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

onMounted(() => {
  fetchCounter()
})

</script>

<style lang="scss">
ul.links {
  margin: 0;
  padding: 0;
  list-style: none;

  li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #eeeeee;
    margin-bottom: 5px;
    border-radius: 4px;
    padding: 0px 20px;

    span {
      background-color: white;
      cursor: pointer;
      border: 2px dashed #ffa7a7;
      padding: 8px 30px;
    }
  }
}
</style>
