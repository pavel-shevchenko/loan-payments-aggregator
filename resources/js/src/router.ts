import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router';
import InputValues from './views/InputValues.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'InputValues',
    component: InputValues,
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ './views/InputValues.vue'),
  },
];

const router = createRouter({
  history: createWebHashHistory(process.env.VUE_BASE_URL),
  routes,
});

export default router;
