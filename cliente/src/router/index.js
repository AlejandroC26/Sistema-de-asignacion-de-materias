import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/Home')
  },
  {
    path: '/profile',
    name: 'Profile',
    component: () => import('../views/Profile'),
    meta: { protectedRoute: false }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('../views/Dashboard'),
    meta: { protectedRoute: false }
  },
  {
    path: '/estudiantes',
    name: 'Estudiantes',
    component: () => import('../views/Estudiantes'),
    meta: { protectedRoute: false }
  },
  {
    path: '/profesores',
    name: 'Profesores',
    component: () => import('../views/Profesores'),
    meta: { protectedRoute: false }
  },
  { path: "*", component: () => import('../views/404'), }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  //about homem only about is protected
  const routeIsProtected = to.matched.some(item => item.meta.protectedRoute);
  if(routeIsProtected && localStorage.getItem('token') === null){
    next('/')
  } else {
    next()
  }
})

export default router
