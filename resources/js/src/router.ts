import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router';
import InputValues from './views/InputValues.vue';
import Calculate from './views/Calculate.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'InputValues',
    component: InputValues,
  },
  {
    path: '/calculate',
    name: 'Calculate',
    component: Calculate,
  },
  {
    path: '/schedule',
    name: 'Schedule',
    // Route level code-splitting
    component: () => import('./views/Schedule.vue'),
  },
];

const router = createRouter({
  history: createWebHashHistory('/'),
  routes,
});

export default router;
