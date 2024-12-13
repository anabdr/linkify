import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import VueApexCharts from "vue3-apexcharts"
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';


createApp(App)
.use(store)
.use(router)
.use(VueApexCharts)
.mount('#app')
