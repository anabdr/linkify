import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import LinkView from '../views/LinkView.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/link',
    name: 'Link',
    component: LinkView,
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token'); // Verifica si hay un token en localStorage

  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    // Si la ruta requiere autenticación y no está autenticado, redirige al login
    next({ name: 'Login' });
  } else {
    // De lo contrario, permite la navegación
    next();
  }
});

export default router
