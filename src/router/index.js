import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../components/Home.vue'
import Search from '../components/Search.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/search',
    name: 'Search',
    component: Search,
    meta: { requiresAuth: true }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, _from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!localStorage.getItem('jwt')) {
      next({ name: 'Home', params: { next: to.path }})
    } else {
      fetch('authorize.php', {
        method: 'POST',
        body: JSON.stringify({ token: localStorage.getItem('jwt') }),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (response.ok) next()
        else next({ name: 'Home', params: { next: to.path }})
      })
    }
  }
  else next()
})

export default router
