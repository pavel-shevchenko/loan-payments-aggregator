import { createApp, provide, h } from 'vue';
import { IonicVue } from '@ionic/vue';
import { ApolloClient, InMemoryCache } from '@apollo/client';
import { DefaultApolloClient } from '@vue/apollo-composable';
import App from './App.vue';
import router from './router';

/* Core CSS required for Ionic components to work properly */
import '@ionic/vue/css/core.css';

/* Basic CSS for apps built with Ionic */
import '@ionic/vue/css/normalize.css';
import '@ionic/vue/css/structure.css';
import '@ionic/vue/css/typography.css';

/* Optional CSS utils that can be commented out */
import '@ionic/vue/css/padding.css';
import '@ionic/vue/css/float-elements.css';
import '@ionic/vue/css/text-alignment.css';
import '@ionic/vue/css/text-transformation.css';
import '@ionic/vue/css/flex-utils.css';
import '@ionic/vue/css/display.css';

/* Ionic theme variables */
import './theme/variables.css';

const defaultClient = new ApolloClient({
  uri: '/graphql',
  cache: new InMemoryCache(),
});

createApp(
  {
    setup() {
      provide(DefaultApolloClient, defaultClient);
    },
    render() {
      return h(App);
    },
  },
).use(IonicVue).use(router).mount('#app');
