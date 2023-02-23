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
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('../views/Dashboard'),
    meta: { protectedRoute: true }
  },
  {
    path: '/estudiantes',
    name: 'Estudiantes',
    component: () => import('../views/Estudiantes'),
    meta: { protectedRoute: true }
  },
  {
    path: '/profesores',
    name: 'Profesores',
    component: () => import('../views/Profesores'),
    meta: { protectedRoute: true }
  },
  {
    path: '/asignaturas',
    name: 'Asignaturas',
    component: () => import('../views/Asignaturas'),
    meta: { protectedRoute: true }
  },
  {
    path: '/seleccion-asignaturas',
    name: 'SeleccionAsignaturas',
    component: () => import('../views/SeleccionAsignaturas'),
    meta: { protectedRoute: true }
  },
  {
    path: '/reportes',
    name: 'Reportes',
    component: () => import('../views/Reportes'),
    meta: { protectedRoute: true }
  },
  {
    path: '/perfil',
    name: 'Perfil',
    component: () => import('../views/Profile'),
    meta: { protectedRoute: true }
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
