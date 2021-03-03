import { createRouter, createWebHashHistory, RouteRecordRaw } from 'vue-router';
import InputValues from './views/InputValues.vue';
import Calculate from './views/Calculate.vue';
import Schedule from './views/Schedule.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'InputValues',
    component: InputValues,
    meta: {
      // keepAlive: true,
    },
  },
  {
    path: '/calculate',
    name: 'Calculate',
    component: Calculate,
    meta: {
      // keepAlive: true,
    },
  },
  {
    path: '/schedule',
    name: 'Schedule',
    component: Schedule,
    meta: {
      // keepAlive: true,
    },
  },
];

const router = createRouter({
  history: createWebHashHistory('/'),
  routes,
});

export default router;
