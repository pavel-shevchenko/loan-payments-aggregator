<template>
  <ion-page>
    <ion-content>
      <keep-alive>
        <router-view v-if="$route.meta.keepAlive"/>
      </keep-alive>
      <router-view v-if="!$route.meta.keepAlive"/>
    </ion-content>

    <ion-segment @ionChange="pageChanged($event)" value="parameters">
      <ion-segment-button value="parameters">
        <ion-label>Parameters</ion-label>
      </ion-segment-button>
      <ion-segment-button value="calculate">
        <ion-label>Calculate</ion-label>
      </ion-segment-button>
      <ion-segment-button value="payment_schedule">
        <ion-label>Payment schedule</ion-label>
      </ion-segment-button>
    </ion-segment>
  </ion-page>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import {
  IonPage,
  IonSegment,
  IonSegmentButton,
  IonToolbar,
} from '@ionic/vue';

@Options({
  components: {
    IonPage,
    IonSegment,
    IonSegmentButton,
    IonToolbar,
  },
})
export default class App extends Vue {
  pageChanged(e: CustomEvent) {
    if (e.detail.value === 'parameters') {
      this.$router.push({ name: 'InputValues' });
    } else if (e.detail.value === 'calculate') {
      this.$router.push({ name: 'Calculate' });
    } else if (e.detail.value === 'payment_schedule') {
      this.$router.push({ name: 'Schedule' });
    }
  }
}
</script>

<style lang="scss">
</style>
